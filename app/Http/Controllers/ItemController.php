<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use mysqli;
use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use phpDocumentor\Reflection\Types\Integer;

class ItemController extends Controller
{
    public function create ()
    {
        $user = Auth::user();
        return view('items.new', compact($user));
    }

    public function store (\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $owner = $user['email'];

        $data = $_POST;
        //$file = $_FILES;

        //$avatar = request()->file('avatar');
        //$filename = time() . '.' . $avatar->getClientOriginalExtension();

        $name = $data['ItemName'];
        $description = $data['Description'];
        $available = 'TRUE';


        if($request->hasFile('avatar')){//array_key_exists ('avatar', $data ) && $data['avatar'] != '') {
            $avatar = request()->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/items/' . $filename ) );

            $sql = "insert into items (description, available, name, owner, avatar) values ('".$description."', '"
                   .$available."', '".$name."', '".$owner."', '".$filename."');";
            //print($sql);
            //return 1;
        }
        else {
            $sql = "insert into items (description, available, name, owner) values ('".$description."', '"
                .$available."', '".$name."', '".$owner."');";
            //print($sql);
            //return 1;
        }
        //$avatar = $request->file('avatar');

        //print($request);

        $db = new mysqli('localhost', 'root', 'admin', 'blog');
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }

        $db->query($sql);


        $userid = $user['id'];
        return redirect('users/'.$userid);
    }

    public function editShow ($itemId)
    {

        $db = new mysqli('localhost', 'root', 'admin', 'blog');
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $sql = "select * from items i where i.itemid = ". $itemId.";";
        $items_owned = $db->query($sql);

        $row = $items_owned->fetch_assoc();
        $itemName = $row['name'];
        $itemDescription = $row['description'];

        //$this->delete($itemId);

        return view('items.edit', compact('itemId', 'itemName','itemDescription'));
    }

    public function editUpdate ($itemId)
    {
        $input = Request::all();
        $user = Auth::user();
        $userid = $user['id'];
        $itemName = $input['ItemName'];
        //$itemId = $input['itemId'];
        $itemDescription = $input['Description'];
        $db = new mysqli('localhost', 'root', 'admin', 'blog');
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $sql = "UPDATE items SET items.description = '".$itemDescription."', items.name = '".$itemName."' where items.itemid = ".$itemId.";";

        $db->query($sql);
        return redirect('users/'.$userid);
    }

    public function delete ($itemId)
    {
        $user = Auth::user();
        $userid = $user['id'];

        $db = new mysqli('localhost', 'root', 'admin', 'blog');
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $sql = "DELETE from items where items.itemid = ".$itemId.";";
        $db->query($sql);
        return redirect('users/'.$userid);

    }

    public function post ($itemId)
    {
        return view('posts.new', compact('itemId'));
    }

}
