<?php

$loader = include('vendor/autoload.php');
$loader->add('', 'Src');

Use Missions\ModelMission;
Use Connexion\ModelConnexion;
Use Recherche\ModelRecherche;
//Use Contenu\ModelContenu;
Use Mail\ModelMail;

$app = new Silex\Application;
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => './views'));

$app['modelMission'] = new ModelMission();
$app['modelConnexion'] = new ModelConnexion();
$app['modelRecherche'] = new ModelRecherche();
//$app['modelContenu'] = new ModelContenu();
$app['modelMail'] = new ModelMail();

// Page d'accueil
$app->match('/', function() use ($app) {
    return $app['twig']->render('home.html.twig');
})->bind('home');

$app->get('/search', function() use ($app) {
    if(isset($_GET['query'])) {
    // Mot tapé par l'utilisateur
        $q = htmlentities($_GET['query']);
        return $app['modelRecherche']->getContentsSearch($q);
    }
})->bind('search');

$app->match('/search/{lib}', function($lib) use ($app) {
        $page = $app['modelRecherche']->getPathByName($lib);
        $path = $page['path'];
        return $app->redirect('../'.$path);
})->bind('searchID');

$app->get('/missionsJSON', function() use ($app) {
    return $app['modelMission']->getMissionsJSON();
})->bind('missionsJSON');

$app->get('/logout', function() use ($app){
    $app['session']->remove('user');
    return $app['twig']->render('home.html.twig');
})->bind('logout');

$app->post('/login', function() use ($app) {
    $app['session']->set('erreur', "");
    if (isset($_POST['login']) && isset($_POST['pass'])) {
        $user = $app['modelConnexion']->GetUtilisateurByLogin($_POST['login'], $_POST['pass']);
        if($user != null){
            //var_dump($user);
            $app['session']->set('user', $user);
            return $app['twig']->render('missions.html.twig', array(
                'formation' => $app['modelMission']->getFormations(),
                'semestre' => $app['modelMission']->getSemestres(),
                'moduleS1' => $app['modelMission']->getModulesBySemestre(1),
                'moduleS2' => $app['modelMission']->getModulesBySemestre(2),
                'chargeTd' => $app['modelMission']->getIntervenants(2),
                'enseignant' => $app['modelMission']->getIntervenants(1)
            ));
        }else{
            $erreur = "Votre login et/ou mot de passe sont erronés";
            $app['session']->set('erreur', $erreur);
        }
    }
    if($_POST['login'] == ""){
        $erreur = "Vous devez renseigner votre identifiant.";
        $app['session']->set('erreur', $erreur);
    } 
    if($_POST['pass'] == ""){
        $erreur = "Vous devez renseigner votre mot de passe.";
        $app['session']->set('erreur', $erreur);
    }
    //Pas de connexion redirection page précedante
    return $app->redirect($_SERVER['HTTP_REFERER']);
})->bind('login');

// Page d'hier à aujourd'hui
$app->match('/aujourdhui', function() use ($app) {
    return $app['twig']->render('hier.html.twig');
})->bind('hier');

// Page partenariat
$app->match('/partenariat', function() use ($app) {
    return $app['twig']->render('partenariat.html.twig');
})->bind('partenariat');

// Page quelquesChiffres
$app->match('/quelquesChiffres', function() use ($app) {
    return $app['twig']->render('quelquesChiffres.html.twig');
})->bind('quelquesChiffres');

// Page licence
$app->match('/licence', function() use ($app) {
    return $app['twig']->render('licence.html.twig');
})->bind('licence');

// Page master
$app->match('/master', function() use ($app) {
    return $app['twig']->render('master.html.twig');
})->bind('master');

// Page contact
$app->match('/contact', function() use ($app) {
    $message = null;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['nom']) && $_POST['mail'] && $_POST['message']){
            if(isset($_POST['sujet'])){
                $app['modelMail']->envoieMail($_POST['nom'], $_POST['mail'], $_POST['message'], $_POST['sujet']);   
            }else{
                $app['modelMail']->envoieMail($_POST['nom'], $_POST['mail'], $_POST['message']);
            }
            $message = "Votre mail a bien été envoyé";
        }
    }
    return $app['twig']->render('contact.html.twig', array("message"=>$message));
})->bind('contact');

// Page medias
$app->match('/medias', function() use ($app) {
    return $app['twig']->render('medias.html.twig');
})->bind('medias');

// Page missions
$app->match('/missions', function() use ($app) {
    return $app['twig']->render('missions.html.twig', array(
        'formation' => $app['modelMission']->getFormations(),
        'semestre' => $app['modelMission']->getSemestres(),
        'moduleS1' => $app['modelMission']->getModulesBySemestre(1),
        'moduleS2' => $app['modelMission']->getModulesBySemestre(2),
        'chargeTd' => $app['modelMission']->getIntervenants(2),
        'enseignant' => $app['modelMission']->getIntervenants(1)
    ));
})->bind('missions');

// Récupération des missions
$app->match('/getMissions', function() use ($app){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        return $app['modelMission']->getMissionsJSON();
    }
})->bind('getMissions');

// Details d'une mission
$app->match('/detailsMission', function() use ($app){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_REQUEST['id'])){
            return $app['modelMission']->getDetailsMissionById($_REQUEST['id']);
        }
    }
})->bind('detailsMission');

// Creation d'une mission
$app->match('/createMission', function() use ($app){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) 
            && isset($_POST['idFormation']) && isset($_POST['idModule'])){
            $app['modelMission']->addMission($_POST['title'], $_POST['start'], $_POST['end'], $_POST['fiche'], $_POST['idModule']
                , $_POST['idFormation'], $_POST['bgColor'], $_POST['txtColor'], $_POST['typeEval'], $_POST['coefEval']
                , $_POST['dateEval'], $_POST['idChargeTD'], $_POST['idEnseignant']);
            
        }
        return true;
    }
})->bind('createMission');

// Suppression d'une mission
$app->match('/deleteMission', function() use ($app){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_REQUEST['id'])){
            $app['modelMission']->delMissionById($_REQUEST['id']);
            return true;
        }
    }
})->bind('deleteMission');

// Update d'une mission
$app->match('/updateMission', function() use ($app){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['start']) 
        && isset($_POST['end']) && isset($_POST['idFormation']) && isset($_POST['idModule'])){
            $app['modelMission']->updateMission($_POST['id'], $_POST['title'], $_POST['start'], $_POST['end'], $_POST['fiche'], $_POST['idModule']
                , $_POST['idFormation'], $_POST['bgColor'], $_POST['txtColor'], $_POST['typeEval'], $_POST['coefEval']
                , $_POST['dateEval'], $_POST['idChargeTD'], $_POST['idEnseignant']);
            return $app->redirect('./missions');
        }
    }
})->bind('updateMission');

// Page etudiant
$app->match('/etudiant', function() use ($app) {
    //$contenu = $app['modelContenu']->getContenuPage(4);
    //return $app['twig']->render('etudiant.html.twig', array("contenu"=>$contenu));
    return $app['twig']->render('etudiant.html.twig');
})->bind('etudiant');

// Page professionnel
$app->match('/professionnel', function() use ($app) {
    return $app['twig']->render('professionnel.html.twig');
})->bind('professionnel');

// Page chiffre
$app->match('/chiffre', function() use ($app) {
    return $app['twig']->render('chiffre.html.twig');
})->bind('chiffre');

// Page condition d'utilisation
$app->match('/conditions', function() use ($app) {
    return $app['twig']->render('conditions.html.twig');
})->bind('conditions');

// Page condition d'utilisation
$app->match('/mentions', function() use ($app) {
    return $app['twig']->render('mentions.html.twig');
})->bind('mentions');

// Fait remonter les erreurs
/*
$app->error(function($error) {
    throw $error;
});*/

$app->error(function (\Exception $e, $code) use ($app) {
    if ($code == 404) {
        return $app['twig']->render('error.html.twig');
    }
    return false;
});

$app->run();
