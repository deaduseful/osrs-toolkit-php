<?php

use opensrs\domains\dnszone\DnsDelete;

/**
 * @group dnszone
 * @group DnsDelete
 */
class DnsDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'dnsDelete';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain: the domain for which you want
             *   to delete DNS records
             */
            'domain' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));
        $data->attributes->domain = 'phptest'.time().'.com';

        $ns = new DnsDelete('array', $data);

        $this->assertTrue($ns instanceof DnsDelete);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));
        $data->attributes->domain = 'phptest'.time().'.com';

        if (is_null($message)) {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$field.*not defined/"
              );
        } else {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$message/"
              );
        }

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new DnsDelete('array', $data);
    }
}
