<?php
/**
 * Created by PhpStorm.
 * User: devert
 * Date: 2/17/19
 * Time: 12:30 AM
 */
namespace Devert\Util;

class TestFormatter{

    const SKIPPED = "SKIPPED";
    const PASSED = "PASSED";
    const FAILED = "FAILED";
    const ERROR = "ERROR";
    const INCOMPLETE = "INCOMPLETE";

    /**
     * @param array $data
     * @return array
     */
    public static function process(array $data) : array {
        foreach($data['testsuite'] as $testsuite){
            $suite = ucwords(str_replace('_', ' ', $testsuite['@attributes']['name']));

            foreach($testsuite['testcase'] as $testcase) {
                if (isset($testcase['skipped'])) {
                    $status = self::SKIPPED;
                }
                else if(isset($testcase['failure'])) {
                    $status = self::FAILED;
                }
                else {
                    $status = self::PASSED;
                }
                if($status == self::PASSED && $testcase['@attributes']['assertions'] ==0) {
                    $status = self::SKIPPED;
                }
                $signature = $testcase['@attributes']['file'] .':'. $testcase['@attributes']['name'];
                $subCategory = (new self)->subCategory($testcase['@attributes']['file']);
                $category = (new self)->category($testcase['@attributes']['file']);
                $case = ucfirst($testcase['@attributes']['feature']);
                $time = $testcase['@attributes']['time'];
                $assertions = $testcase['@attributes']['assertions'];
                $testcases[] = array(
                    'category' => $category,
                    'subCategory' => $subCategory,
                    'component' => $suite,
                    'signature' => $signature,
                    'case' => $case,
                    'status' => $status,
                    'time' => $time,
                    'assertions' => $assertions
                );
            }
            $tests[] = array(
                'suite' => $suite,
                'testcases' => $testcases
            );
            $testcases = [];
        }
        return $tests;
    }

    /**
     * @param string $path
     * @return string
     */
    public function category(string $path) : string {
        $explode = explode('/', $path,-1);
        $rawCategory = $explode[count($explode ) - 1];
        $underscorePos = strpos($rawCategory,'_') + 1;
        $category = substr($rawCategory, $underscorePos);
        return $this->convertCamelCaseToSentence($category);
    }

    /**
     * @param string $path
     * @return string
     */
    public function subCategory(string $path) : string {
        $lastSlashPos = strrpos($path, '/') + 1;
        $lastString = substr($path, $lastSlashPos);
        $rawSubCategory = str_replace('Cest.php', '', $lastString);
        return $this->convertCamelCaseToSentence($rawSubCategory);
    }

    /**
     * @param string $str
     * @return string
     */
    public function convertCamelCaseToSentence(string $str) : string {
        $parts = preg_split("/(?=[A-Z])/", $str);
        $sentence = implode(' ', $parts);
        return ucwords(trim($sentence));
    }
}
