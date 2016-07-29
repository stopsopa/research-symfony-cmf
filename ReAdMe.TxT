steps to run after installing symfony-cmf

next step is to install libraries requirede by jackrabbit !!! very important:
    http://symfony.com/doc/1.0/cmf/cookbook/installing_configuring_doctrine_phpcr_odm.html#download-the-bundles

con doctrine:database:create
con doctrine:phpcr:init:dbal --force

con doctrine:phpcr:repository:init

# once again started from :
http://symfony.com/doc/master/cmf/quick_tour/the_big_picture.html



        php app/console doctrine:database:create
        php app/console doctrine:phpcr:init:dbal --force
        php app/console doctrine:phpcr:workspace:purge --force
        php app/console doctrine:phpcr:repository:init

        php app/console doctrine:phpcr:migrator:migrate page --identifier=/cms/simple/test
        php app/console doctrine:phpcr:migrator:migrate page --identifier=/cms/simple/quick_tour
        php app/console doctrine:phpcr:fixtures:load --append --no-interaction

        php app/console doctrine:phpcr:node:dump --props




content repository jackrabbit jackalope midgard2


to explore data inside jackrabbit :
	https://github.com/phpcr/phpcr-shell/releases/
	http://phpcr.readthedocs.io/en/latest/phpcr-shell/installation.html

	wget link from github
	mv file.phar /usr/local/bin/phpcrsh
	chmod a+x /usr/local/bin/phpcrsh

	this will create profile 'myprofile' and store it in ~/.phpcrsh/profiles/myprofile.yml

	# http://phpcr.readthedocs.io/en/latest/phpcr-shell/connecting.html#phpcrsh-profile

		phpcrsh --transport=jackrabbit -pmyprofile

	# after creating providing creadentials and createing profile, next time you need to execute only

		phpcrsh -pmyprofile

		.. to enter to the shell

	# later traverse using 'pwd', 'ls' and 'cd' commands
	# you can see what are these aliases by typing 'aliases'

	/cms/aml/pages/aml-today

	*   If you login from cli or from command sf2
		you need to create profile which contain parameters of connection to content repository endpoint
		and after you just enter to shell using this profile.

	*   Then another level is


# praca z odm query builder:
	http://doctrine-orm.readthedocs.io/projects/doctrine-phpcr-odm/en/latest/reference/query-builder.html

	Doctrine\ODM\PHPCR\DocumentManager







