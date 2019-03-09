<?php

require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}


$junitXmlPath = 'report.xml';

if (($junit_xml_data = file_get_contents($junitXmlPath))===false){
    throw new Exception("Error fetching JUnit XML");
} else {
    libxml_use_internal_errors(true);
    $formatted = Devert\Util\XmlToArray::convert($junit_xml_data);
    if (!$formatted) {
        echo "Error loading XML\n";
        foreach(libxml_get_errors() as $error) {
            echo "\t", $error->message;
        }
        exit(1);
    } else {
        $testcases = \Devert\Util\TestFormatter::process($formatted);
    }
}

// Get the API client and construct the service object.
















// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1lfoCKSJz3yfd6TsWmVt8idLFFjfgwOU9e2Yu4NOv1KI/edit

$spreadsheetId = '1lfoCKSJz3yfd6TsWmVt8idLFFjfgwOU9e2Yu4NOv1KI';
//$range = 'Bom!B5:G';
//$dimension = 'ROWS';
//$valueInputOption = 'USER_ENTERED';
//$googleSheetRange = new  Google_Service_Sheets_BatchUpdateValuesRequest();
//$googleSheetRange->setValueInputOption($valueInputOption);
//$googleSheetRange->setIncludeValuesInResponse(true);
//$googleSheetRange->setData(
//    array(
//        array(
//            'range' => $range,
//            'majorDimension' => $dimension,
//            'values' => array(
//                array("Item", "Cost", "Stocked", "Ship Date"),
//                array("Wheel", "$20.50", "4", "3/1/2016"),
//                array("Door", "$15", "2", "3/15/2016"),
//                array("Engine", "$100", "1", "30/20/2016"),
//                array("Totals", "=SUM(B2:B4)", "=SUM(C2:C4)", "=MAX(D2:D4)")
//            )
//        ),
//        array(
//            'range' => 'Components!B5:G',
//            'majorDimension' => $dimension,
//            'values' => array(
//                array("Item", "Cost", "Stocked", "Ship Date"),
//                array("Wheel", "$20.50", "4", "3/1/2016"),
//                array("Door", "$15", "2", "3/15/2016"),
//                array("Engine", "$100", "1", "30/20/2016"),
//                array("Totals", "=SUM(B2:B4)", "=SUM(C2:C4)", "=MAX(D2:D4)")
//            )
//        )
//    )
//);
//$response = $service->spreadsheets_values->batchGet(
//    $spreadsheetId,
//    array($range));

//print_r($response);

//$response = $service->spreadsheets_values->batchUpdate($spreadsheetId, $googleSheetRange);
//var_dump($response);

//if (empty($values)) {
//    print "No data found.\n";
//} else {
//    print "Name, Major:\n";
//    foreach ($values as $row) {
//        // Print columns A and E, which correspond to indices 0 and 4.
//        var_dump("%s, %s\n", $row);
//    }
//}


$googleSheet = new \Devert\Util\GoogleSheet();
$googleSheet->updateSpreadSheet($spreadsheetId, $testcases);



