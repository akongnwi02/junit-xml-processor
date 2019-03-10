# junit-xml-processor
This library processes JUnix XML report file and displays result on a google spreadsheet.

# How to use
You need a report configuration file in JSON format

```
{
  "spreadsheetId": "1lfoCKSJz3yfd6TsWmVt8idLFFjfgwOU9e2Yu4NOv1KI",
  "google-credentials": "google-credentials.json",
  "xml": "report.xml"
}
```
run `vendor/bin/report path/to/config`

The project is still very young and contributions are welcomed.

