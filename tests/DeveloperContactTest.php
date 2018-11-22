<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DeveloperContactTest extends TestCase
{
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
                "firstname"=> "Deola1",
                "lastname"=> "Habib1",
                "email"=> "deola.habbib1@gmail.com",
                "skypeid"=> "deola1.habbib1",
                "linkedin"=> "http://www.linkedin.com/deola-habbib1",
                "phoneno"=> "2347065396751",
                "country"=> "Nigeria"
            ];

            $this->post("api/category/fullstack", $parameters, []);
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
                  "firstname"=> "Adeola",
                  "lastname"=> "Habib",
                  "email"=> "deolss.habbib@gmail.com",
                  "skypeid"=> "deola.habbib",
                  "linkedin"=> "http://www.linkedin.com//deola-habbib",
                  "phoneno"=> "2347065396750",
                  "country"=> "Nigeria"
            ];
            $this->put("api/developers/21", $parameters, []);
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
        public function testShouldDeleteProduct(){

            $this->delete("products/5", [], []);
            $this->seeStatusCode(410);
            $this->seeJsonStructure([
                    'status',
                    'message'
            ]);
        }


}
