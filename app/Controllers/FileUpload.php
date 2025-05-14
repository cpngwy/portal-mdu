<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Factoring as FactoringModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
class FileUpload extends BaseController
{
    public function upload($id, $file_name, $dir)
    {
        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post'):
        
            $validationRule = [
                'pdf_file' => [
                    'label' => 'Pdf File',
                    'rules' => [
                        'uploaded[pdf_file]',
                        'mime_in[pdf_file,application/pdf]',
                        'max_size[pdf_file,2048]',
                    ],
                ],
            ];

            if (! $this->validate($validationRule)):
            
                return redirect()->to('/factoring/edit/'.$id)->with('errors', $this->validator->getErrors());

            endif;

            $document_file = $this->request->getFile('pdf_file');

            if ($document_file->isValid() && ! $document_file->hasMoved()):
                
                $time = new Time();
                $ymd = sprintf('%s%s%s_', $time->getYear(), $time->getMonth(), $time->getDay());
                $filepath = WRITEPATH . 'uploads/' . $document_file->store($dir.'/', $file_name.'.pdf');
                
                log_message('info', 'FilePath: '.$filepath);
                // $data = [
                //     'filepath' => $filepath,
                //     'filename' => $document_file->getClientName(),
                // ];
                $data = [
                    'file' => $dir.'/'.$file_name.'.pdf', 
                    'invoice_url' => base_url('/factoring/link/'.$file_name.'.pdf')
                ];
                $model = new FactoringModel();
                $model->update($id, $data);
                return redirect()->to('/factoring/edit/'.$id)->with('message', 'The file has been uploaded, please review your "Factoring Details" before you click "Submit Factoring" button!');

            endif;

            return redirect()->to('/factoring/edit/'.$id)->with('errors', 'The file has already been moved.');

        endif;
    }
}
