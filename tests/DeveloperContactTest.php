<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class DeveloperContactTest extends TestCase
{
  use DatabaseTransactions;
    /**
     * api/developers [GET]
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

    /**
     * api/developers/id [GET]
     */

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

    /**
         * api/category/ [POST]
         */
        public function testShouldCreateDeveloperContact(){

            $parameters = [
                //"firstname"=> "Deola1",
                "lastname"=> "Habib1",
                "email"=> "deola.habbib1@gmail.com",
                "skypeid"=> "deola1.habbib1",
                "linkedin"=> "http://www.linkedin.com/deola-habbib1",
                "phoneno"=> "2347065396751",
                "country"=> "Nigeria"
            ];

            $this->post("api/developers", $parameters, []);
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

        /**
         * /api/developers/21 [PUT]
         */
        public function testShouldUpdateDeveloperContact(){
            $parameters = [
              "firstname"=>"Adeola",
            	"lastname"=>"Habib",
            	"email"=>"deols.habbib@gmail.com",
            	"skypeid"=>"deols.habbib",
            	"linkedin"=>"http=>//www.linkedin.com//deols-habbib",
            	"phoneno"=>"234706539908",
            	"country"=>"Nigeria"
            ];
            $this->put("api/developers/5", $parameters, []);
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
        /**
         * /products/id [DELETE]
         */
        public function testShouldDeleteDeveloperContact() {

            $this->delete("api/developers/20", [], []);
            $this->seeStatusCode(410);
            $this->seeJsonStructure([
                    'status',
                    'message'
            ]);
        }

        public function testShouldAddDeveloperContactToCategory() {
            $parameters = [
                "developer_id"=> "2"
            ];
            $this->post("api/category/2", $parameters, []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                    'status',
                    'message'
            ]);
        }


}
