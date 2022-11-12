<?php


# Clean Function to sanitize the data
function Clean($input)
{
    return stripslashes(strip_tags(trim($input)));
}



# Validate Function to validate the data 
function Validate($input, $case, $length = 6)
{

    $status = true;

    switch ($case) {

        case 'required':
            if (empty($input)) {
                $status = false;
            }
            break;

        case 'email':
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $status = false;
            }
            break;

        case 'min':
            if (strlen($input) < $length) {
                $status = false;
            }
            break;

        case 'max':
            if (strlen($input) > $length) {
                $status = false;
            }
            break;

        case 'int':
            if (!filter_var($input, FILTER_VALIDATE_INT)) {
                $status = false;
            }
            break;

        case 'image':

            # Validate Extension . . . 
            $imageType = $input;
            $extensionArray = explode('/', $imageType);
            $extension =  strtolower(end($extensionArray));

            $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];    // PNG 

            if (!in_array($extension, $allowedExtensions)) {

                $status = false;
            }

            break;

        case 'date':
            $dateArray = explode('-', $input);

            if (!checkdate($dateArray[1], $dateArray[2], $dateArray[0])) {
                $status = false;
            }
            break;
    }


    return $status;
}






#  Print  Message Function . . . 
function Message($message = null)
{
    if (isset($_SESSION['Message'])) {
        foreach ($_SESSION['Message'] as $key => $value) {
            # code...
            echo $key . ' : ' . $value . '<br>';
        }

        unset($_SESSION['Message']);
    } else {
        echo ' <li class="breadcrumb-item active">' . $message . '</li>';
    }
}






# DO query Function . . .
function DoQuery($query)
{
    $result = mysqli_query($GLOBALS['con'], $query);
    return $result;
}



# Upload . . . 
function Upload($file)
{

    $extensionArray = explode('/', $file['image']['type']);
    $extension =  strtolower(end($extensionArray));
    # Upload Image . . .
    $finalName = uniqid() . time() . '.' . $extension;
    $disPath = 'uploads/' . $finalName;
    # Get Temp Path . . .
    $tempName  = $file['image']['tmp_name'];

    if (move_uploaded_file($tempName, $disPath)) {
        return $finalName;
    } else {
        return false;
    }
}



# Remove File 
function RemoveFile($file)
{
    $filePath = 'uploads/' . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
        $status = true;
    } else {
        $status = false;
    }
    return $status;
}




// "http://localhost/group14/week3/blog/dashboard/<?php echo $module


function url($input){

 return   'http://'.$_SERVER['HTTP_HOST'].'/myims/dashboard/'.$input; 

}



//   function checkOwner($id){

//      if(($_SESSION['user']['role_id'] == 5) && ($_SESSION['user']['id'] != $id)){
     
//             $status = false; 
     
//         }else{
//             $status = true; 
//         }

//         return $status; 
//   }
