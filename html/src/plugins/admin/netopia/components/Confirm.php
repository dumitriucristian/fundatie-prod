<?php
namespace Admin\Netopia\Components;

use Cms\Classes\ComponentBase;
use \Admin\Netopia\Classes\Mobilpay_Payment_Request_Abstract;
use \Admin\Netopia\Classes\Mobilpay_Payment_Request_Card;
use \Admin\Netopia\Classes\Mobilpay_Payment_Invoice;
use \Admin\Netopia\Classes\Mobilpay_Payment_Address;
use Admin\Netopia\Models\Donation;
use Input;
use Validator;
use ValidationException;
use Response;
use Redirect;

class Confirm extends ComponentBase 
{

    public $errorCode 		= 0;
    public $errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_NONE;
    public $errorMessage	= '';


    public function componentDetails()
    {
        return [
            'name' => 'Confirmation page',
            'description' => 'Confirmation page'
        ];
    }


    public function onRun()
    {
        $content = $this->getResponse();
        //Response::make($content)->header('Content-Type', 'application/xml');

        //return Redirect::to('/return?id=ceva');
    }

    public function setDonationStatus($orderId, $status)
    {
         Donation::where('payment_id',$orderId)->update(['status' => $status]);
    }

    public function getResponse()
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') == 0)
        {
            if(isset($_POST['env_key']) && isset($_POST['data']))
            {
                #calea catre cheia privata
                #cheia privata este generata de mobilpay, accesibil in Admin -> Conturi de comerciant -> Detalii -> Setari securitate
               
                $paymentUrl = env('PAYMENT_URL');
                $private_cert_file = env('CERT_PRIVATE');
                $privateKeyFilePath 	= plugins_path(env('CERT_PATH').$private_cert_file);
                
                try
                {
                $objPmReq = Mobilpay_Payment_Request_Abstract::factoryFromEncrypted($_POST['env_key'], $_POST['data'], $privateKeyFilePath);
                #uncomment the line below in order to see the content of the request

               

                $rrn = $objPmReq->objPmNotify->rrn;
                // action = status only if the associated error code is zero
                
                if ($objPmReq->objPmNotify->errorCode == 0) {
                        switch($objPmReq->objPmNotify->action)
                        {
                        #orice action este insotit de un cod de eroare si de un mesaj de eroare. Acestea pot fi citite folosind $cod_eroare = $objPmReq->objPmNotify->errorCode; respectiv $mesaj_eroare = $objPmReq->objPmNotify->errorMessage;
                        #pentru a identifica ID-ul comenzii pentru care primim rezultatul platii folosim $id_comanda = $objPmReq->orderId;
                    case 'confirmed':
                            #cand action este confirmed avem certitudinea ca banii au plecat din contul posesorului de card si facem update al starii comenzii si livrarea produsului
                        //update DB, SET status = "confirmed/captured"
                        $this->setDonationStatus($objPmReq->orderId, 'confirmed');
                        $this->errorMessage = $objPmReq->objPmNotify->errorMessage;
                        break;
                    case 'confirmed_pending':
                            #cand action este confirmed_pending inseamna ca tranzactia este in curs de verificare antifrauda. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                        //update DB, SET status = "pending"
                        $this->setDonationStatus($objPmReq->orderId, 'confirmed_pending');
                        $this->errorMessage = $objPmReq->objPmNotify->errorMessage;
                    break;
                    case 'paid_pending':
                       
                            #cand action este paid_pending inseamna ca tranzactia este in curs de verificare. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                        //update DB, SET status = "pending"
                        $this->setDonationStatus($objPmReq->orderId, 'paid_pending');
                        $this->errorMessage = $objPmReq->objPmNotify->errorMessage;
                    break;
                    case 'paid':
                            #cand action este paid inseamna ca tranzactia este in curs de procesare. Nu facem livrare/expediere. In urma trecerii de aceasta procesare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                        //update DB, SET status = "open/preauthorized"
                        $this->setDonationStatus($objPmReq->orderId, 'paid');
                    $this->errorMessage = $objPmReq->objPmNotify->errorMessage;
                    break;
                    case 'canceled':
                            #cand action este canceled inseamna ca tranzactia este anulata. Nu facem livrare/expediere.
                        //update DB, SET status = "canceled"
                        $this->setDonationStatus($objPmReq->orderId, 'canceled');
                    $this->errorMessage = $objPmReq->objPmNotify->errorMessage;
                    break;
                    case 'credit':
                            #cand action este credit inseamna ca banii sunt returnati posesorului de card. Daca s-a facut deja livrare, aceasta trebuie oprita sau facut un reverse. 
                        //update DB, SET status = "refunded"
                        $this->setDonationStatus($objPmReq->orderId, 'refunded');
                    $this->errorMessage = $objPmReq->objPmNotify->errorMessage;
                    break;
                default:
                    $this->errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
                    $this->errorCode 		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_ACTION;
                    $this->errorMessage 	= 'mobilpay_refference_action paramaters is invalid';
                    break;
                    }
                }else {
                     //update DB, SET status = "rejected"
                     $this->setDonationStatus($objPmReq->orderId, 'rejected');
                    $this->errorMessage = $objPmReq->objPmNotify->errorMessage;
                    $this->errorCode =  $objPmReq->objPmNotify->errorCode;
          	        //$this->errorType = Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_TEMPORARY; <-- am comentat aici ca sa dezactivez err type 
                    }
                }
                catch(Exception $e)
                {
                    $this->errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_TEMPORARY;
                    $this->errorCode		= $e->getCode();
                    $this->errorMessage 	= $e->getMessage();
                }
            }
            else
            {
                $this->errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
                $this->errorCode		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
                $this->errorMessage 	= 'mobilpay.ro posted invalid parameters';
            }
        }
        else 
        {
            $this->errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
            $this->errorCode		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_METHOD;
            $this->errorMessage 	= 'invalid request metod for payment confirmation';
        }

        header('Content-type: application/xml');
        header('Status: 200');
        $content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        
        if($this->errorCode == 0)
        {
           $content .= "<crc>{$this->errorMessage}</crc>";

        }
        else
        {
           $content .= "<crc error_type=\"{$this->errorType}\" error_code=\"{$this->errorCode}\">{$this->errorMessage}</crc>";
        }

        echo  $content;
    }
    
}
