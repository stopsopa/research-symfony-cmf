# once again started from :
http://symfony.com/doc/master/cmf/quick_tour/the_big_picture.html

# To start working with symfony-cmf install version from documentation
 	http://symfony.com/doc/current/cmf/book/installation.html#installation


		composer create-project symfony-cmf/standard-edition cmf '1.2.1'
			steps to run after installing symfony-cmf	

		next step is to install libraries required by jackrabbit !!! very important:
		    http://symfony.com/doc/1.0/cmf/cookbook/installing_configuring_doctrine_phpcr_odm.html#download-the-bundles

 	and to be ready to switch database to jackrabbit you need to add to composer.json
 		"jackalope/jackalope-jackrabbit": "*"
        	and
        composer require doctrine/orm
 	sometimes after adding this it will be necessary to remove composer.lock and vendors
 	and run composer install once again 	


 		# on init
 		composer run-script --dev post-install-cmd
        php app/console assets:install --symlink --relative

			# only if db is in other db then jackrabbit  
	        php app/console doctrine:database:create
	        php app/console doctrine:phpcr:init:dbal --force
	        php app/console doctrine:phpcr:repository:init

        # if working with jackrabbit start from here 

        php app/console doctrine:phpcr:workspace:purge --force
        php app/console doctrine:phpcr:repository:init

        php app/console doctrine:phpcr:migrator:migrate page --identifier=/cms/simple/test
        php app/console doctrine:phpcr:migrator:migrate page --identifier=/cms/simple/quick_tour
        php app/console doctrine:phpcr:fixtures:load --append --no-interaction

        # to see what is inside (data inspection commands):
        php app/console doctrine:phpcr:node:dump
        php app/console doctrine:phpcr:node:dump --props
		php app/console doctrine:phpcr:mapping:info        


	


teraz powinno być dostępne z przeglądarki tutaj:
	http://rabbit.test:8080/

inne "content repository" : jackrabbit jackalope midgard2


==== PHPCRSH ====== vvv
to explore data inside jackrabbit :
	https://github.com/phpcr/phpcr-shell/releases/
	http://phpcr.readthedocs.io/en/latest/phpcr-shell/installation.html

	wget link from github
	sudo mv phpcrsh.phar /usr/local/bin/phpcrsh
	sudo chmod a+x /usr/local/bin/phpcrsh

	this will create profile 'myprofile' and store it in ~/.phpcrsh/profiles/myprofile.yml
	# http://phpcr.readthedocs.io/en/latest/phpcr-shell/connecting.html#phpcrsh-profile

		phpcrsh --transport=jackrabbit -pmyprofile

	# after creating providing creadentials and createing profile, next time you need to execute only

		phpcrsh -pmyprofile

		.. to enter to the shell

	# later traverse using 'pwd', 'ls' and 'cd' commands
	# you can see what are these aliases by typing 'aliases'
	# AVAILABLE COMMANDS:
		save, refresh
		shell:alias:list
			# from http://phpcr.readthedocs.io/en/latest/phpcr-shell/configuration.html
		ls -L2
			# from http://phpcr.readthedocs.io/en/latest/phpcr-shell/interacting.html
		ls /cms/lh/pages/therapies/*/*
		php app/console doctrine:phpcr:shell "node:list -L2"
		 	# from http://phpcr.readthedocs.io/en/latest/phpcr-shell/connecting.html#connect-to-an-embedded-phpcr-shell

	# eploring options:
		# http://phpcr.readthedocs.io/en/latest/phpcr-shell/querying.html#array-replace
			# PHPCRSH> UPDATE [nt:unstructured] SET tags = array_replace(tags, 'Planes', NULL)
			
	# useful queries : 
	SELECT * FROM [nt:unstructured];  - typ pola jest pod jcr:primaryType
	select * from [rep:root];
	select [nt:unstructured].[allowChildren] from [nt:unstructured];   
	select [nt:unstructured].[allowChildren] from [nt:unstructured] order by [nt:unstructured].[allowChildren] desc;
		# from http://phpcr.readthedocs.io/en/latest/book/query.html
		
	
==== PHPCRSH ====== ^^^

===== QUERY BUILDER ===== 

        /* @var $dm DocumentManager; */
        $dm = $this->container->get('doctrinePhpcr')->getManager();

        $session = $dm->getPhpcrSession();

        $qb = $dm->createQueryBuilder();

        $qb->fromDocument('Cms\CoreBundle\Document\Page', 'p');

        $path = "/cms/{$this->container->getParameter('site')}/pages/about";

        $qb->where()->descendant("/cms/{$this->container->getParameter('site')}/pages/about", 'p')->end();

        $qb->andWhere()->same($path . "/obry", 'p')->end();

        $qb->orderBy()->asc()->field('p.sortOrder')->end();

        $qb->setMaxResults(2);

        $list = $qb->getQuery()->getResult();
	
===== QUERY BUILDER ===== 

	/cms/aml/pages/aml-today

	*   If you login from cli or from command sf2
		you need to create profile which contain parameters of connection to content repository endpoint
		and after you just enter to shell using this profile.

	*   Then another level is

# praca z odm query builder:
	http://doctrine-orm.readthedocs.io/projects/doctrine-phpcr-odm/en/latest/reference/query-builder.html

	Doctrine\ODM\PHPCR\DocumentManager



# another browser/online manager: 	
	https://github.com/marmelab/phpcr-browser
	http://i.imgur.com/eAI2vbT.png
	g(PHPCR Browser provides an intuitive web interface to explore and manage PHPCR repositories)







