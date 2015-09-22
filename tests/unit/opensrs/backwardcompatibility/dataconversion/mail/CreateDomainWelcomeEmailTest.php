<?php

use OpenSRS\backwardcompatibility\dataconversion\mail\CreateDomainWelcomeEmail;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group publishing
 * @group BC_MailCreateDomainWelcomeEmail
 */
class BC_CreateDomainWelcomeEmailTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        "data" => array(
            "admin_username" => "",
            "admin_password" => "",
            "admin_domain" => "",
            )
        );

    /**
     * Valid conversion should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validconversion
     */
    public function testValidDataConversion() {
        $data = json_decode( json_encode ($this->validSubmission) );

        $data->data->admin_username = 'phptest' . time();
        $data->data->admin_password = 'password1234';
        $data->data->admin_domain = 'mail.phptest' . time() . '.com';

        $shouldMatchNewDataObject = new \stdClass;
        $shouldMatchNewDataObject->attributes = $data->data;

        $ns = new CreateDomainWelcomeEmail();
        $newDataObject = $ns->convertDataObject( $data );

        $this->assertTrue( $newDataObject == $shouldMatchNewDataObject );
    }
}
