<?php

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

    public function changebgAction()
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
        return $this->render('ThemesBundle:Default:changebg.html.twig',array('css'=>$cssTheme,'js'=>$jsTheme,'availThemes'=>$availThemes,'currTheme'=>$currentTheme) );
    }
}
