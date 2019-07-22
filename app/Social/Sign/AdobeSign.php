<?php

namespace App\Social\Sign;

class AdobeSign
{
    private $clientId = 'CBJCHBCAABAAFdmS_9bPi0n6KoP6BdOMS0hh4-cB-HYP';
    private $clientSecret = 'J3wiTr7B_luFI5y-nfseTt0McikHVQA8';
    private $OauthCode;
    private $token;
    private $refreshToken = '3AAABLblqZhBmfMg_9k25eT9983TefabXf3MSpoBk32nEOBS1tQ43Wq-_GujnMX3-x2JsdJDYVUEGrj7aVp9dK-EUgPidhO2o';
    private $toRefreshToken = '3AAABLblqZhBQh4DC_V97gkYmsxr-HXcqvIEpVkGs8iSvOdTLu8J_aCI2NAsnaA4iVQt-4PX1oBY*';
    private $grant_type;
    private $redirectUri;


    private $refreshTokenUrl = 'https://secure.eu1.echosign.com/oauth/refresh';
    private $tokenUrl = 'https://secure.eu1.echosign.com/oauth/refresh';
    private $documentLibraryUrl = 'https://api.eu1.echosign.com:443/api/rest/v6/libraryDocuments';
    private $agreementUrl = 'https://api.eu1.echosign.com:443/api/rest/v6/agreements';
    private $uploadDocumentUrl = 'https://api.eu1.echosign.com:443//api/rest/v6/transientDocuments';

    private $savedEditedContractPath;
    private $savedEditedContractFilename;


    private $documentId = '';

    public function refreshToken()
    {
        $handle = curl_init();

        $postData = "client_id=$this->clientId&client_secret=$this->clientSecret&grant_type=refresh_token&refresh_token=$this->toRefreshToken";

        $header = array();
        $header[] = 'Content-Type: application/x-www-form-urlencoded';

        curl_setopt_array($handle,
            array(
                CURLOPT_URL => $this->refreshTokenUrl,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => $header,
            )
        );

        $data = curl_exec($handle);

        if ($data === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            print_r('Curl error: ' . curl_error($handle));
            curl_close($handle);
            return false;
        } else {
            $decodedData = json_decode($data);
            $this->refreshToken = $decodedData->access_token;
            curl_close($handle);
            return true;

        }
    }

    public function editDoc($data)
    {
        $public_path = public_path();

        $file = $public_path . '/contract-templates/' . "Master&Publishing(MagicRecordsOnly).docx";

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);

        $templateProcessor->setValue('real_name', $data['real_name']);
        $templateProcessor->setValue('artist_name', $data['artist_name']);
        $templateProcessor->setValue('address', $data['address']);
        $templateProcessor->setValue('deal_type', $data['deal_type']);
        $templateProcessor->setValue('master_split', $data['master_split']);
        $templateProcessor->setValue('publishing_split', $data['publishing_split']);

        $this->savedEditedContractPath =  $public_path . '/signed-contracts/' . "Master&Publishing(MagicRecordsOnly)" . '-' . $data['artist_name'] . '.docx';
        $this->savedEditedContractFilename = "Master&Publishing(MagicRecordsOnly)" . '-' . $data['artist_name'] . '.docx';
        $templateProcessor->saveAs($this->savedEditedContractPath);

        return true;

    }

    public function sendToSign($data)
    {
        $okEdit = $this->editDoc($data);

        if ($okEdit) {
            $okRefresh = $this->refreshToken();
            $okUploadWord = $this->uploadDocumentWordFormat();

            if ($okUploadWord && $okRefresh) {
                $okUploadToLibrary = $this->uploadDocumentToLibrary();

                if ($okUploadToLibrary) {
                    $handle = curl_init();

                    if (empty($this->documentId)) {
                        echo 'NO DOCUMENT ID TO SEND';
                        return;
                    }

                    $postData = array(
                        'fileInfos' => array(array(
                            'transientDocumentId' => $this->documentId
                        )),
                        'name' => 'This is a test sign document',
                        'participantSetsInfo' => array(array(
                            'memberInfos' => array(array(
                                'email' => $data['email']
                            )),
                            'order' => 1,
                            'role' => 'SIGNER'
                        )),
                        'signatureType' => 'ESIGN',
                        'state' => 'IN_PROCESS'
                    );
                    $postDataString = json_encode($postData);

                    //echo $postDataString;


                    $header = array();
                    $header[] = 'Content-Type: application/json';
                    $header[] = 'Authorization: Bearer ' . $this->refreshToken;
                    $header[] = 'Content-Length: ' . strlen($postDataString);

                    curl_setopt_array($handle,
                        array(
                            CURLOPT_URL => $this->agreementUrl,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postDataString,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_HTTPHEADER => $header,
                            CURLINFO_HEADER_OUT => true,
                            //CURLOPT_HEADER => true
                        )
                    );

                    $data = curl_exec($handle);

                    if ($data === false) {
                        // throw new Exception('Curl error: ' . curl_error($crl));
                        print_r('Curl error: ' . curl_error($handle));
                        curl_close($handle);
                        return false;
                    } else {
                        print_r($data);
                        curl_close($handle);
                        return true;

                    }
                }
            }
        }
        // $this->refreshToken();

    }

    public function uploadDocument()
    {
        $handle = curl_init();

        $file = __DIR__ . DIRECTORY_SEPARATOR . "test.pdf";

        $header = array();
        $header[] = 'Content-Type: multipart/form-data';
        $header[] = 'Authorization: Bearer ' . $this->refreshToken;
        $header[] = 'Content-Disposition: form-data; name=";File"; filename="test.PDF"';

        // Send the raw file in the body with no other data
        $fp = fopen($file, 'r');
        $contents = fread($fp, filesize($file));

        $postData = array(
            "File" => $contents,
            "File-Name" => 'test.PDF',
            "Mime-Type" => 'application/pdf'
        );

        curl_setopt_array($handle,
            array(
                CURLOPT_URL => $this->uploadDocumentUrl,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $header,
            )
        );

        $data = curl_exec($handle);

        if ($data === false)
        {
            //throw new Exception('Curl error: ' . curl_error($handle));
            print_r('Curl error: ' . curl_error($handle));

            curl_close($handle);
            fclose($fp);

            return false;
        } else
        {
            $decoded = json_decode($data);

            curl_close($handle);
            fclose($fp);
            $this->documentId = $decoded->transientDocumentId;
            return $decoded->transientDocumentId;

        }

    }

    public function uploadDocumentWordFormat()
    {
        $handle = curl_init();
        $file = $this->savedEditedContractPath;
        $fileName = $this->savedEditedContractFilename;

        $header = array();
        $header[] = 'Content-Type: multipart/form-data';
        $header[] = 'Authorization: Bearer ' . $this->refreshToken;
        $header[] = 'Content-Disposition: form-data; name=";File"; filename="' . $fileName . '"'; //testEdit.docx"';

        // Send the raw file in the body with no other data
        $fp = fopen($file, 'r');
        $contents = fread($fp, filesize($file));

        $postData = array(
            "File" => $contents,
            "File-Name" => $fileName,
            "Mime-Type" => 'application/msword'
        );

        curl_setopt_array($handle,
            array(
                CURLOPT_URL => $this->uploadDocumentUrl,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $header,
            )
        );

        $data = curl_exec($handle);

        if ($data === false)
        {
            //throw new Exception('Curl error: ' . curl_error($handle));
            print_r('Curl error: ' . curl_error($handle));

            curl_close($handle);
            fclose($fp);

            return false;
        } else
        {
            $decoded = json_decode($data);

            curl_close($handle);
            fclose($fp);
            $this->documentId = $decoded->transientDocumentId;
            return true;

        }
    }

    public function uploadDocumentToLibrary()
    {
        //$this->uploadDocument();

        $handle = curl_init();

        if (empty($this->documentId)) {
            echo 'NO DOCUMENT ID TO SEND';
            return;
        }

        $postData = array(
            'fileInfos' => array(array(
                'transientDocumentId' => $this->documentId
            )),
            'name' => 'This is a test sign document',
            'sharingMode' => 'ACCOUNT',
            'state' => 'ACTIVE',
            'signatureType' => 'ESIGN',
            'templateTypes' => array(
                "DOCUMENT"
            )
        );
        $postDataString = json_encode($postData);


        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Bearer ' . $this->refreshToken;
        $header[] = 'Content-Length: ' . strlen($postDataString);

        curl_setopt_array($handle,
            array(
                CURLOPT_URL => $this->documentLibraryUrl,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postDataString,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $header,
                CURLINFO_HEADER_OUT => true,
                //CURLOPT_HEADER => true
            )
        );

        $data = curl_exec($handle);

        if ($data === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            print_r('Curl error: ' . curl_error($handle));
            curl_close($handle);
            return false;
        } else {
            print_r($data);
            curl_close($handle);
            return true;

        }
    }
    public function writeToDoc($name, $bio)
    {
        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText($name);

// Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText($bio);
        $myTextElement->setFontStyle($fontStyle);

// Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.docx');


        \PhpOffice\PhpWord\Settings::setPdfRendererPath('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
        $xmlWriter->save('test.pdf');
    }
}
