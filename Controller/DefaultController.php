<?php
/*
    Symfony Themesbundle, to allow easy changing of themes, and body backgrounds.
    Copyright (C) 2016  Justin Fuhrmeister-Clarke

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace ThemesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ThemesBundle:Default:index.html.twig');
    }

    public function footerAction()
    {
        chdir('../src/ThemesBundle/');
        include 'Controller/currentTheme.php';

	$cssTheme=$currentTheme;
	$jsTheme=$currentTheme;
        return $this->render('ThemesBundle:Default:footer.html.twig',array('css'=>$cssTheme,'js'=>$jsTheme) );
    }

    public function changethemeAction()
    {
	chdir('../src/ThemesBundle/');
	include 'Controller/currentTheme.php';

        if (isset($_GET['newTheme'])) {
		$currentTheme=$_GET['newTheme'];
		$newConfig="<?php\n\$currentTheme=\"$currentTheme\";";
		file_put_contents('Controller/currentTheme.php',$newConfig);
	}
	
	$files = scandir(getcwd().'/Resources/public/themes/');
//	$files=array();
	foreach ($files as $file) {

	}
	$cssTheme=$currentTheme;
	$jsTheme=$currentTheme;

	$availThemes=$files;
	//$currentTheme=getcwd();
        return $this->render('ThemesBundle:Default:changeTheme.html.twig',array('css'=>$cssTheme,'js'=>$jsTheme,'availThemes'=>$availThemes,'currTheme'=>$currentTheme) );
    }
    public function changebgAction()
    {
	$errors=false;
	$success=false;
	$debug=false;
	$target_file = "./bundles/themes/background.jpg";
	$overtarget_file = "../src/ThemesBundle/Resources/public/background.jpg";
	$defaultovertarget_file = "../src/ThemesBundle/Resources/public/defaultbg.jpg";

	if(isset($_POST["submit"])) {
	$debug=print_r($_FILES,true);
//var_dump($_FILES);
//	$target_dir = "uploads/";
//	$target_file = $target_dir . basename($_FILES["newbg"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["newbg"]["tmp_name"]);
	    if($check !== false) {
	        $debug .="File is an image - " . $check["mime"] . ".\n";
	        $uploadOk = 1;
	    } else {
	        $errors.= "File is not an image.<br>";
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    unlink($target_file);
//	    echo "Sorry, file already exists.";
//	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    $errors.= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    $errors.= "Sorry, your file was not uploaded.<br>";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["newbg"]["tmp_name"], $target_file)) {
		copy($target_file,$overtarget_file);
	        $success.= "The file ". basename( $_FILES["newbg"]["name"]). " has been uploaded.<br>";
	    } else {
	        $errors.= "Sorry, there was an error uploading your file.<br>";
	    }
	}
	}
	if(isset($_POST["default"])) {
		if(copy($defaultovertarget_file,$overtarget_file))
			$success.="Copyied default to /src/<br>";
		if(copy($defaultovertarget_file,$target_file))
			$success.="Copyied default to /web/bundles<br>";

	}
        return $this->render('ThemesBundle:Default:changebg.html.twig', array('error'=>$errors,'success'=>$success,'debug'=>$debug ) );
    }
}
