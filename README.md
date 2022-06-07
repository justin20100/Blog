# School project at HEPL 🇧🇪
## Un blog

Votre tâche est de commencer à réaliser un blog alimenté par des fichiers au format *json*, donc sans DB.

Ce blog est construit grâce à un template proposé sur tailwindcomponents.com. Le lien CSS pointe vers la feuille de style en ligne. Je ne suis pas responsable du balisage proposé.

Les articles du blog sont stockés dans des fichiers *json*, un par article. C’est une *mauvaise idée* et on ne fait pas ça dans la vraie vie, car les performances découlant d’une telle stratégie se dégraderont très vite avec l’augmenation du nombre de fichiers. Mais pour cet exercice, vous procéderez ainsi puisque nous n’avons pas encore travaillé avec des DBs.  

Dans un fichier, un article est donc un objet *json* avec un `id`, un titre (`title`), un résumé (`excerpt`), un texte (`body`), une date de publication (`published_at`) qui correspond à sa date d’enregistrement, un nom d’auteur (`author_name`), un avatar d’auteur (`author_avatar`) et un nom de catégorie (`category`).

Le nom du fichier est l’`id` du post un identifiant arbitraire, unique.

Le repo contient un script *generate.php* qui vous permet de générer des articles. Avant de l’utiliser (*run* dans PHPStorm ou via le navigateur sinon), vous devez installer Faker en exécutant une des deux commandes suivantes, selon votre environnement :

	- `lando composer install` 
	- `docker exec -it myapp-php composer install`

## Les actions du blog

Il y a quatre actions possibles dans ce blog : lister les posts ; afficher un post ; afficher le formulaire de création d’un post et enregistrer un post dans un fichier. 

Toutes les requêtes HTTP pointent vers `/index.php`. Pour distinguer entre les trois « pages » prévues dans le site (index des articles ; vue d’un seul article ; formulaire), vous devrez passer un argument dans la *query-string*. Celui-ci se nommera `action` et prendra les valeurs : `index` pour obtenir la liste des posts ; `show` pour obtenir un post unique ; `create` pour obtenir le formulaire de création et `store` enregistrer un post dans un fichier.

## Afficher un post

Je vous conseille de commencer par ici. C’est la tâche la plus simple et elle est déclenchée par une *query-string* de la forme `?action=show&id=62376cea1ba1c`. 

La vérification principale concerne l’id. Il doit correspondre à un fichier existant. Si ce n’est pas le cas, vous pouvez rediriger vers une page nommée 404.php. 

Le reste n’est que du templating.

## Créer un post

Ensuite, je vous conseille de passer à cette action. La QS `action=create` permet de voir le formulaire. La soumission de ce dernier permet de sauver le nouvel article (`action=store`) dans le fichier. 

Les informations de l’auteur à savoir son nom et son avatar, sont codés en dur et ne doivent pas venir du formulaire. Reprenez un des auteurs dans un des fichiers *json* existants, au choix.

Le formulaire doit être validé : les champs contenant le titre de l’article, l’excerpt et le corps de l’article sont requis. Le titre aura une taille comprise entre 5 et 100 caractères unicode, l’excerpt entre 20 et 200, le corps, entre 100 et 1000. 

La catégorie doit être une des valeurs existantes dans les articles déjà présents et choisie depuis le select.

La stratégie de validation sera de stocker les erreurs de validation dans une variable de session, ensuite de rediriger vers le formulaire (avec l’entête `Location: une-adresse` ) et de vérifier lors de l’affichage de celui-ci si des erreurs existent dans la session. Si c’est le cas, prévoyez de les afficher là où il est intéressant de les afficher, près des champs concernés. Et n’oubliez pas de repeupler le formulaire avec les données en question.

## Lister les posts

Elle est accessible sans querystring ou avec la QS `?action=index`

La liste est *toujours* paginée. Seuls quelques posts sont effectivement affichés même si au départ, tous sont chargés en mémoire. Pour choisir une page, on utilise la QS `p`, qui indique la page à afficher.

Si paginer est déjà une manière de filtrer, un autre filtre, peut s’ajouter à la pagination. Soit la liste est filtrée par auteur, `author`, soit par catégorie `category`.  

Les posts sont aussi triés. Soit les nouveaux d’abord, soit les anciens d’abord. `?order-by=oldest` ou `order-by=newest`. Dans cet exercice, je ne demande pas de tenir compte des filtres appliqués avant de changer d’ordre. Le changement d’ordre de tri redémarre donc la liste à la première page et supprime les filtres éventuels par auteur ou par catégorie. 

Quand on change de page alors qu’on est en train de voir les posts d’un auteur ou d’une catégorie, il faut naturellement continuer de filtrer selon cet auteur ou cette catégorie. Il faut donc construire les liens en tenant compte de la QS existante.

Naturellement, pour tous ces arguments de QS, il faut vérifier qu’ils correspondent à quelque chose qui existe, sans quoi, il faut renvoyer vers la page 404 ou prévoir de revenir à la valeur initiale de chaque argument. Par exemple, si il y a 5 pages et qu’on demande la 7, on peut réafficher la 1 ou aller à une 404. Du point de vue strict, on devrait aller vers la 404, mais l’expérience utilisateur de revenir à la page 1 serait sans doute acceptable également dans la mesure où c’est vraiment une tentative d’utilisation illicite qui est en cours.

## Les vues

La factorisation des vues est possible de plusieurs façons. Je vous propose de créer des *partials* pour :

- la navigation, proposée en deux versions, *connected* et *not-connected* ;
- le menu secondaire sur la droite (*authors*, *categories*, *recent posts*) ;
- le select au-dessus de la liste des articles ;
- la pagination.
# Blog
