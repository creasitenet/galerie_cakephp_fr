<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Network\Exception\BadRequestException;
//use Cake\Filesystem\Folder;
//use Cake\Filesystem\File;

class PicturesController extends AppController {
  		
  	public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['ajax_add','postAjaxUpload','getAjaxRefresh','getDelete']);
    }

    public function index() {
    	$pictures = $this->Pictures->find('all', [
    		'order' => ['Pictures.created' => 'ASC']
		]);	//debug($todos); die();
        $this->set('pictures', $pictures);
    }

	// Upload // Ajax // Json.
    public function postAjaxUpload() {
    	if(!$this->request->is('ajax')) {
	        throw new BadRequestException();
	    }
	    $this->autoRender = false;
        $d['result'] = 0; 	
				
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $erreur = "Seule la methode POST est autorisée ici.";
		}
		
		// Préparation
        if (!isset($error)) {
	        $fileup=$_FILES['Filedata'];
	        $fileup_name=$_FILES['Filedata']['name'];
	        $fileup_size=$_FILES['Filedata']['size'];
	        $fileup_error=$_FILES['Filedata']['error'];
	        $fileup_type=$_FILES['Filedata']['type'];
	        $fileup_tmp_name=$_FILES['Filedata']['tmp_name'];
	        $files_errors = array(
	        0=>"Upload réussi..",
	        1=>"Le fichier est trop lourd.",
	        2=>"La photo est trop grande.",
	        3=>"Le fichier n'a été que partiellement téléchargé.",
	        4=>"Aucun fichier n'a été uploadé.",
	        6=>"Pas de dossier temporaire, contactez le webmaster.",
	        7=>"Échec de l'écriture du fichier sur le disque."
	        );
	        if($fileup_error!=0) { // Erreur
	            $error = $files_errors[$fileup_error];
	        }
    	}

        // Extension 
        if (!isset($error)) {
        	$fileup_name_lower = strtolower($fileup_name); // EN MINUSCULE
        	$fileup_extension = substr(strrchr($fileup_name_lower, '.'),1); // EXTENSION EN MINUSCULE SANS LE POINT
        	$fileup_base = basename($fileup_name_lower,'.'.$fileup_extension); // UN NOM EN MINUSCULE SANS EXTENSION        	
        	$fileup_name_temp = Inflector::slug($fileup_base, '-', true); // ON NETTOIRE ENCORE        	
        	$fileup_new_name=$fileup_name_temp.'.'.$fileup_extension;
	        //$document_auth_extensions = array ('doc', 'fla', 'pdf', 'swf', 'txt');
	        //if (!in_array($fileup_extension, $document_auth_extensions)) {
	        //    $error = $fileup_name." : Extension de fichier non supportée !";
	        //}
	        $picture_auth_extensions = array ('bmp', 'gif', 'iff', 'jp2', 'jpg', 'jpeg', 'png', 'psd', 'tiff', 'wbmp');
	        if (!in_array($fileup_extension, $picture_auth_extensions)) {
	            $error = $fileup_name." : Extension de fichier non supportée !";
	        }
	    }

        // Poid maximum
        if (!isset($error)) {
	        if(($fileup_size==0) OR ($fileup_size > 2000000)) {
	            if($fileup_size==0) {
	                 $error = 'Fichier de 0 ko !';
	            } elseif ($fileup_size>2000000) {
	                $error = $fileup_name." : trop lourd : Max 2mo !"; 
	            }
	        }
	    }

        // Taille // Seulement pour les images
        if (!isset($error)) {
		        $fileup_dim = getimagesize($fileup_tmp_name);
		        if (($fileup_dim[0] > 1024) OR ($fileup_dim[1] > 1024)) {
		            $error = $fileup_name." trop grande : Max 1024 x 1024 pixels !";
		        }
	    }

        // Déplacement du dossier tmeporaire au dossier TEMP souhaité 
        if (!isset($error)) {
	        $fileup_temporaire = 'server/TEMP/'.$fileup_new_name; //Chemin de l'image dans une variable.	        
	        if (!move_uploaded_file($fileup_tmp_name, $fileup_temporaire)) { //Déplacement du fichier avec le son nom d'origine
	            $error = $fileup_name." n'a pas été copié correctement !";
	        }
	    }
		
	    // imagecreatefrom // Seulement pour les images
        if (!isset($error)) {
				if ($fileup_extension=='jpg') { $fileup_extensionx='jpeg'; } else { $fileup_extensionx=$fileup_extension; }
				try {
				    @call_user_func('imagecreatefrom'.$fileup_extensionx,$fileup_temporaire);
				} catch (Exception $e) {
				    $error = $fileup_name." : Exception : ".$e->getMessage();
				}
		}
		
		// Enregistrement en base de donnée
		// Déplacement
        if (!isset($error)) {
            $Pictures = TableRegistry::get('Pictures');
            $e = $Pictures->newEntity();
			$e->slug =  $fileup_new_name;
			$e->file_extension = $fileup_extension;
			$e->file_type = $fileup_type;
			$e->file_size = $fileup_size;
			if ($Pictures->save($e)) {
				if ($fileup_dim[0]>900) {
					//Image::load($fileup_temporaire)->resize(900);
				}				
				$fileup_final_destination = 'server/pictures/'.$e->id.'-'.$fileup_new_name; //Chemin de l'image dans une variable.				
				copy($fileup_temporaire, $fileup_final_destination); // Déplacement du fichier 
				unlink($fileup_temporaire);  // on supprime l'image 00 
				$d['result'] = 1;
				$d['message'] = "Photo ajoutée.";
			} else {
				$d['message'] = "Impossible d'ajouter la photo : si le problème persiste, contactez le webmaster.";
			}
        } else { // Sinon erreur
            $d['message'] = $error;        	
        }
		// Retour json
		$this->set('_serialize', $d);
		echo json_encode($d);
    }

	// Get Ajax Refresh de la liste des photos, retour html
	public function getAjaxRefresh() {
    	if(!$this->request->is('ajax')) {
	        throw new BadRequestException();
	    }
	    $this->layout = 'empty'; //$this->viewBuilder()->layout('empty');
		$this->autoRender = false;	
    	$pictures = $this->Pictures->find('all', [
    		'order' => ['Pictures.created' => 'ASC']
		]);	//debug($todos); die();
        $this->set('pictures', $pictures);
        $this->render('_pictures');
    }
		
	// Get Supprimer photo
	public function getDelete($id) {
		$e= $this->Pictures->get($id);
		$fileimg = 'server/pictures/'.$e->id.'-'.$e->slug;
		//debug($fileimg); die();
		if (unlink($fileimg)) {
			$this->Pictures->delete($e);
        	//$this->Flash->success('La photo a été supprimée.');
        	$this->Flash->set("La photo n'a été correctement supprimée du serveur.", ['element' => 'growl_success']);
		} else {
        	//$this->Flash->error("");
        	$this->Flash->set("La photo n'a été correctement supprimée du serveur.", ['element' => 'growl_error']);
		}
		
		return $this->redirect(['action' => 'index']);
	}
	
	
}
