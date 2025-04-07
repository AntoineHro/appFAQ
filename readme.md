Descriptif README.

Descriptif du contenu du dépôt:

  appFAQ: contient l'application dans son ensemble, le fichier contier les pages PHP et CSS
  BDDappFAQ: contient le fichier "BDDappFAQ.sql" permettant la création de la base de données
  data appFAQ: contient le fichier "data.sql" qui permet l'insertion des utilisateurs, admins et super admin



Descriptif procédure d'installation (en 3 étapes majeures):

I-Installation de l'application
  1.
    Téléchargez les fichiers appFAQ sur votre PC.
  2.
    Déposez le fichier dans votre fichier de configuration XAMPP/htdocs/projets/
  3.
    Installez le fichier BDDappFAQ.sql et déposez le sur votre bureau.
  4.
    Installez le fichier data.sql et désposez le sur votre bureau.
    
II-Création de la base de données
  1.Création appFAQ: 
      a.
        Lancez XAMPP (MySQL databse et Apache Web Serveur)
      b.
        Allez sur votre navigateur.
      c.
        Rentrez dans l'URL "localhost".
      d.
        Cliquez sur phpMyAdmin dans la navbar.
      e.
        Cliquez sur New (sur le coté gauche de votre écran).
      f.
        Rentrez dans le champs "Database name" le nom de la base de donnée: appFAQ
      g.
        Chosissez le language "utf8mb4_general_ci"
      h.
        CLiquez sur CREATE.
  2.Importation appFAQ (peuplement)
      a.
        Cliquez sur la base de données sur la gauche de votre écran (elle est à coté d'un symbole cylindrique normalement).
      b.
        Cliquez sur importez dans la navbar.
      c.
        Selectionnez le fichier BDDappFAQ.sql disponible sur votre bureau.
      d.
        Cliquez sur import.
      
III-Insertion des données
  1.
    Cliquez sur la base de données sur la gauche de votre écran (elle est à coté d'un symbole cylindrique normalement).
  2.
    Cliquez sur importez dans la navbar.
  3.
    Selectionnez le fichier data.sql disponible sur le dépot.
  4.
    Cliquez sur import.


Données (Username/Password):
