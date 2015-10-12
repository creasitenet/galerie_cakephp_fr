<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

use Cake\Collection\Collection;
	
/**
 * Picture Entity.
 */
class Picture extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'slug' => true,
        'file_extension' => true,
        'file_type' => true,
        'file_size' => true,
    ];
	
	
	// Url de la photo
	public function uri() {
		if (file_exists('./server/pictures/'.$this->id.'-'.$this->slug)) {
			$img_url='server/pictures/'.$this->id.'-'.$this->slug;
			return $img_url;
		} else {
			$img_url='webroot/img/nopicture.jpg';
			return $img_url;
		}
	}
	
	
}
