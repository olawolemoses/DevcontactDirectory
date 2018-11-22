<?php
namespace App\Transformers;
use App\DeveloperContact;
use League\Fractal;

class DeveloperContactTransformer extends Fractal\TransformerAbstract
{
	public function transform(DeveloperContact $developerContact)
	{
	    return [
	        'id'      => (int) $developerContact->id,
	        'firstname'   => $developerContact->firstname,
	        'lastname'   => $developerContact->lastname,
	        'email'   =>    $developerContact->email,
	        'skypeid'   => $developerContact->skypeid,
	        'linkedin'    =>  $developerContact->linkedin,
	        'phoneno'    =>  $developerContact->phoneno,
	        'country'    =>  $developerContact->country,
	        'developer_category'    =>  $developerContact->developerCategory,
            'links'   => [
                [
                    'uri' => 'developers/'.$developerContact->id,
                ]
            ],
	    ];
	}
}
