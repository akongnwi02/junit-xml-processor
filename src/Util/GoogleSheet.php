<?php
/**
 * Created by PhpStorm.
 * User: devert
 * Date: 3/8/19
 * Time: 10:06 PM
 */

namespace Devert\Util;

use Devert\GoogleClient;

class GoogleSheet
{
    private $google_credentials;

    private $token_path;

    public function __construct($google_credentials, $token_path = null)
    {
        $this->google_credentials = $google_credentials;
        $this->token_path = $token_path;
    }

    const RUNS_NUMBER_FILED = '!D2';
    const DATA_RANGES = '!A3:';
    const MAJOR_DIMENSION = 'ROWS';
    const VALUE_INPUT_OPTION = 'USER_ENTERED';

    /**
     * Updates the google spreadsheet
     * @param string $spreadsheetId
     * @param string $range
     * @param string $dimension
     * @param string $valueInputOption
     * @param int $runNumber
     * @param array $suite
     * @param string $currentRange
     * @return \Google_Service_Sheets_BatchUpdateValuesResponse
     * @throws \Exception
     */
    public function update(
        string $spreadsheetId,
        string $range,
        string $dimension,
        string $valueInputOption,
        int $runNumber,
        array $suite,
        string $currentRange
    ) : \Google_Service_Sheets_BatchUpdateValuesResponse
    {
        $currentValues = ($this->get($spreadsheetId, $currentRange))->getValues();
        $googleSheetValuesRequest = new  \Google_Service_Sheets_BatchUpdateValuesRequest();
        $googleSheetValuesRequest->setValueInputOption($valueInputOption);
        $googleSheetValuesRequest->setIncludeValuesInResponse(true);
        $googleSheetValuesRequest->setData(
            $this->getData($suite, $range, $dimension, $runNumber, $currentValues)
        );
        $service = $this->getService();
        $response = $service->spreadsheets_values->batchUpdate($spreadsheetId, $googleSheetValuesRequest);
        return $response;
    }

    /**
     * @param $spreadsheetId
     * @param $range
     * @return \Google_Service_Sheets_ValueRange
     * @throws \Exception
     */
    public function get(
        string $spreadsheetId,
        string $range
    ) : \Google_Service_Sheets_ValueRange
    {
        $service = $this->getService();
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        return $response;
    }

    /**
     * @return \Google_Service_Sheets
     * @throws \Exception
     */
    public function getService() : \Google_Service_Sheets
    {
        return new \Google_Service_Sheets((new GoogleClient($this->google_credentials, $this->token_path))->getClient());
    }

    /**
     * @param string $spreadsheetId
     * @param string $range
     * @return int
     * @throws \Exception
     */
    public function getRunNumbers(
        string $spreadsheetId,
        string $range
    ) : int
    {
        $response = $this->get($spreadsheetId, $range);
        return (int)$response->getValues()[0][0];
    }

    /**
     * @param string $spreadsheetId
     * @param string $range
     * @param string $dimension
     * @param string $valueInputOption
     * @param int $runNumber
     * @return \Google_Service_Sheets_BatchUpdateValuesResponse
     * @throws \Exception
     */
    public function updateRunNumber(
        string $spreadsheetId,
        string $range,
        string $dimension,
        string $valueInputOption,
        int $runNumber
    ) : \Google_Service_Sheets_BatchUpdateValuesResponse
    {
        $googleSheetValuesRequest = new  \Google_Service_Sheets_BatchUpdateValuesRequest();
        $googleSheetValuesRequest->setValueInputOption($valueInputOption);
        $googleSheetValuesRequest->setIncludeValuesInResponse(true);
        $googleSheetValuesRequest->setData(
            array(
                'range' => $range,
                'majorDimension' => $dimension,
                'values' => array(array($runNumber))
            )
        );
        $service = $this->getService();
        $response = $service->spreadsheets_values->batchUpdate($spreadsheetId, $googleSheetValuesRequest);
        return $response;
    }

    /**
     * @param array $suite
     * @param string $range
     * @param string $dimension
     * @param int $runNumber
     * @param array $currentValues
     * @return array
     */
    public function getData(
        array $suite,
        string $range,
        string $dimension,
        int $runNumber,
        array $currentValues = null
    ) : array
    {

        foreach ($suite as $test) {
            $values[] = array(
                $test['component'],
                $test['case'],
                $test['category'],
                $test['subCategory'],
                $test['signature'],
                $test['status']
            );
        }

        if ($currentValues == null) {
            $sheetHeading = array(
                'Component',
                'Test Scenario',
                'Category',
                'Sub category',
                'Signature',
                'Run 1'
            );
            array_unshift($values, $sheetHeading);
            $newValues = $values;
        }
        else {
            $presentSheetHeading = array_shift($currentValues);
            $sheetHeading = array_merge($presentSheetHeading, (array)('Run ' . ($runNumber + 1)));


            foreach ($values as $value) {
                foreach ($currentValues as $currentValue) {
                    $found = 0;
                    // if the signature of a test is found in the other tests
                    // meaning same test, merge the current status
                    if (in_array($value[4], $currentValue)) {
                        $item = array_merge($currentValue, (array)$value['5']);
                        $found = 1;
                        break;
                    }
                }
                if ($found == 0) {
                    $status = array_pop($value);
                    $value[count($value) + $runNumber] = $status;
                    $newValues[] =  $this->sanitize($value);
                }
                else if($found ==1) {
                    $newValues[] = @$item ?: $this->sanitize($value);
                }
            }
            array_unshift($newValues, $sheetHeading);
        }

        $data = array(
            'range' => $range,
            'majorDimension' => $dimension,
            'values' => $newValues
        );
        return $data;
    }

    /**
     * @param array $testcases
     * @param string $spreadsheetId
     * @throws \Exception
     */
    public function updateSpreadSheet(string $spreadsheetId, array $testcases)
    {
        foreach ($testcases as $suite) {
            $component = $suite['suite'];
            $numRuns = $this->getRunNumbers($spreadsheetId, $component.self::RUNS_NUMBER_FILED);
            $currentRange = $component . self::DATA_RANGES.($this->getUpperBound($numRuns));
            $range = $component . self::DATA_RANGES.($this->getUpperBound($numRuns));
            $this->update(
                $spreadsheetId,
                $range,
                self::MAJOR_DIMENSION,
                self::VALUE_INPUT_OPTION,
                $numRuns,
                $suite['testcases'],
                $currentRange
            );
            $this->updateRunNumber(
                $spreadsheetId,
                $component.self::RUNS_NUMBER_FILED,
                self::MAJOR_DIMENSION,
                self::VALUE_INPUT_OPTION,
                $numRuns+1
            );
        }
    }

    /**
     * @param int $runNumber
     * @return string
     */
    public function getUpperBound(int $runNumber) : string
    {
        $upperBound ='F';
        $i = $runNumber;
        for($j=0; $j<$i; ++$j){
            $upperBound++;
        }
        return $upperBound;
    }

    /**
     * @param array $arr
     * @return array
     */
    public function sanitize(array $arr) : array
    {
        for ($i = 0; $i < count($arr); ++$i) {
            if(!array_key_exists($i, $arr)){
                $arr[$i] = '';
            }
        }
        ksort($arr);
        return $arr;
    }
}