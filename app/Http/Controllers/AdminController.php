<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        return view("welcome");
    }

    public function manageHistory()
    {
        $historyFile = DB::table('history_file')
            ->get();

        $historySendMail = DB::table('history_sendmail')
            ->get();

        return view("history", ['historyFile' => $historyFile, 'historySendMail' => $historySendMail]);
    }

    public function manageMail()
    {
        $dataMail = DB::table('manage_mail')
            ->get();
        return view("manageMail", ['dataMail' => $dataMail]);
    }

    public function editMail(Request $data)
    {

        $arrId = DB::table('manage_mail')
        ->select('id')
        ->get();

        for($i=0; $i<count($arrId);$i++)
        {
            $y = 0;
            $status = 'status'.$arrId[$i]->id;
            if (isset($_POST[$status])) {
                $y = 1;
            }
            else{
                $y = 0;
            }
            DB::table('manage_mail')
            ->where('id', $arrId[$i]->id)
            ->update([
                'email' => $_POST['mail'.$arrId[$i]->id],  'status' => $y,
            ]);
        }
        echo '<script language="javascript">';
           echo 'alert("Success")';
           echo '</script>';
        $dataMail = DB::table('manage_mail')
        ->get();
        return view("manageMail", ['dataMail' => $dataMail]);
    }

}
