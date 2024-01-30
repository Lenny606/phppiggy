<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class ReceiptService
{

    public function __construct(
        private Database $database
    )
    {

    }

    /**
     * Validate a file for upload.
     *
     * This method performs various validations on the provided file array to ensure
     * it meets the criteria for a valid upload.
     *
     * @param array|null $file The file information from the $_FILES superglobal.
     * @throws ValidationException If the file is invalid based on various criteria.
     */
    public function validateFile(?array $file)
    {
        //validation , superglobal contains errors
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException(
                [
                    'receipt' => "Failed to upload file"
                ]
            );
        }

        //validation for size
        $maxFileSizeMB = 3 * 1024 * 1024; //in Bytes
        if ($file['size'] > $maxFileSizeMB) {
            throw new ValidationException(
                [
                    'receipt' => "File to large"
                ]
            );
        }

        //validation for stange filenames ... like $ &*# , matching pattern
        $originalFileName = $file['name'];
        if (!preg_match('/^[A-za-z0-9\s._-]+$/', $originalFileName)) {
            throw new ValidationException(
                [
                    'receipt' => "Invalid file name"
                ]
            );
        }

        //validation for types, its common to restrict the types of files (pdf)
        //using MIME types
        $fileType = $file['type'];
        $supportedMIMETypes = [
            'image/jpeg',
            'image/png',
            'image/pdf'
        ];
        if (in_array($fileType, $supportedMIMETypes)) {
            throw new ValidationException(
                [
                    'receipt' => "File type not supported"
                ]
            );
        }
    }

    /**
     * Upload a validated file to the server.
     *
     * This method takes a validated file array and performs the file upload process.
     *
     * @param array|null $file The validated file information from the $_FILES superglobal.
     * @throws ValidationException|\Exception If the upload fails.
     */
    public function uploadFile(?array $file, int $transactionId): void
    {
        $orignalName = $file['name'];
        $fileExtension = pathinfo($orignalName, PATHINFO_EXTENSION);

        //random binary converted to hex + extension
        $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;

        $uploadPath = Paths::STORAGE_UPLOADS . "/" . $newFileName;

        //upload function + store in dir , return bool, throw exception if fails
        if (!move_uploaded_file($file['temp_name'], $uploadPath)) {
            throw new ValidationException([
                'receipt' => "Upload failed"
            ]);
        }

        $this->database->query("
        INSERT INTO 'receipts' (
        transaction_id, original_filename, storage_filename, media_type
        ) VALUES (:transaction_id, :original_filename, :storage_filename,:media_type)", [
           'transaction_id' => $transactionId,
            'original_filename' => $file['name'],
            'storage_filename' => $newFileName,
            'media_type' => $file['type'],
        ]);
    }
}