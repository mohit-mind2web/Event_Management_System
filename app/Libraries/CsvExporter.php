<?php

namespace App\Libraries;

class CsvExporter
{
    /**
     * Export data to a CSV file and force download.
     *
     * @param string $filename The name of the file to download (e.g., 'export.csv')
     * @param array $headers The CSV header row
     * @param array $data The data array
     * @param callable $rowFormatter A callback function to format each row
     */
    public function export(string $filename, array $headers, array $data, callable $rowFormatter)
    {
        // Set headers to force download
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Open output stream
        $file = fopen('php://output', 'w');

        // Write header row
        fputcsv($file, $headers);

        // Write data rows
        foreach ($data as $item) {
            $formattedRow = $rowFormatter($item);
            fputcsv($file, $formattedRow);
        }

        // Close stream and exit
        fclose($file);
        exit;
    }
}
