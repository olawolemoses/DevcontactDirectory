<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DeveloperContactTest extends TestCase
{
    /**
     * /products [GET]
     */
    public function testShouldReturnAllDeveloperContacts(){
        $this->get("api/developers", []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'firstname',
                    'lastname',
                    'email',
                    'skypeid',
                    'linkedin',
                    'phoneno',
                    'country',
                    'developer_category',
                    'links'
                ]
            ],
            'meta' => [
                'pagination' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                    'links',
                ]
            ]
        ]);

    }

    public function testShouldReturnDeveloperContact(){
        $this->get("/api/developers/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                  'firstname',
                  'lastname',
                  'email',
                  'skypeid',
                  'linkedin',
                  'phoneno',
                  'country',
                  'developer_category',
                  'links'
                ]
            ]
        );
    }

  

}
