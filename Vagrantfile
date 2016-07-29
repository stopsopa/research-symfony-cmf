Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: ENV["REACT_ELASTIC"] || "172.18.0.170"
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "2524"
    vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
    
    vb.name = "vagrant-jackrabbit"
  end
  config.vm.hostname = "vagrant-jackrabbit"
  
  config.vm.synced_folder ".", "/vagrant/vbox", type: "nfs"
  config.vm.provision "shell", inline: <<-SHELL
    echo "---------------- start ------------- vvv";
    cd /vagrant/vbox
    echo -e "cd /vagrant/vbox\\n" > /home/vagrant/vbox
    chmod a+x /home/vagrant/vbox
    
        echo "==== apt-get update =====";  
    
    echo 'y' | apt-add-repository ppa:ondrej/php5-5.6
               
    apt-get update --fix-missing
    apt-get dist-upgrade
    
        echo "==== apt-get install =====";
        
    apt-get install -y curl nginx php5-fpm php5-cli php5-mysql php5-sqlite php5-intl php5-curl php5-mcrypt git-core php5-xdebug mysql-client
    
        echo "==== install php ====";              
    
    # https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-12-04#step-five—configure-php
        echo "==== hginx ;cgi.fix_pathinfo=1 =====";
        
    sed -ri "s/;cgi\\.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php5/fpm/php.ini            
    
        echo "==== setup nginx root dir ====";
        
    sed -ri "s/root \\/usr\\/share\\/nginx\\/html;/root \\/vagrant\\/vbox\\/web;/g" /etc/nginx/sites-enabled/default 
    
        echo "==== setup nginx app.php ====";
        
    sed -ri "s/index index\\.html index\\.htm;/index index\\.html index\\.htm app\\.php;/g" /etc/nginx/sites-enabled/default                
    
        echo "==== setup host ====";
        
    sed -ri "s/ipv6only=on;/ipv6only=on;\\nerror_log \\/vagrant\\/error\\.log;\\naccess_log \\/vagrant\\/access\\.log;\\nlocation ~ \\\\\\.php$ {\\nfastcgi_pass unix:\\/var\\/run\\/php5-fpm\\.sock;\\nfastcgi_index app\\.php;\\ninclude fastcgi_params;\\n}\\nsendfile off;\\n/g" /etc/nginx/sites-enabled/default   
        
        echo "==== vbox -> hosts =====";                
        
    sed -i '1s/^/1.1.1.1 vbox\\n/' /etc/hosts    
    
        echo "==== get vhost ip ====";
    
    VBOX=$(ifconfig | awk '/inet addr/{print substr($2,6)}'  | head -2 | tail -1)
    
        echo "==== steup rc.local =====";
        
    cp /etc/rc.local /etc/rc.local.copy
    echo -e "VBOX=\\$(ifconfig | awk '/inet addr/{print substr(\\$2,6)}'  | head -2 | tail -1)\\n" > /etc/rc.local    
    echo -e "sed -r -i.bak \\"s@[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\s+vbox@\\$VBOX vbox@g\\" /etc/hosts\\nexit 0" >> /etc/rc.local        

        echo "==== timezone cli ====="

    sed -ri "s/;date\\.timezone =/date\\.timezone = Europe\\/Berlin/g" /etc/php5/cli/php.ini

        echo "==== timezone php5-fpm ====="

    sed -ri "s/;date\\.timezone =/date\\.timezone = Europe\\/Berlin/g" /etc/php5/fpm/php.ini
    
        echo "==== setup xdebug php5enmod & php5dismod ===="

    echo -e "\\nxdebug.remote_enable=1\\nxdebug.remote_host=host\\nxdebug.remote_port=9000\\n" >> /etc/php5/mods-available/xdebug.ini
    
        echo "==== execute setup of vbox ====";
        
    sed -r -i.bak "s@[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\s+vbox@$VBOX vbox@g" /etc/hosts    
    
        echo '==== composer ====';

    curl -sS https://getcomposer.org/installer | php &> /dev/null && mv composer.phar /usr/local/bin/composer    
    
        echo '==== phpunit ====';
    
    wget https://phar.phpunit.de/phpunit.phar &> /dev/null && chmod +x phpunit.phar && mv phpunit.phar /usr/local/bin/phpunit && phpunit --version

        echo "==== setup bash root user ====";

    curl http:\\/\\/httpd.pl\\/\\/bundles\\/toolssitecommon\\/tools\\/bash\\/bashrc.sh.unc 2> /dev/null | bash

        echo "==== setup bash vagrant user ====";

    su vagrant -c "curl http:\\/\\/httpd.pl\\/\\/bundles\\/toolssitecommon\\/tools\\/bash\\/bashrc.sh.unc 2> /dev/null | bash"    
    
        echo "==== restart nginx ====";
        
    service nginx restart
    
        echo "==== restart php5-fpm ====";
        
    service php5-fpm restart
    
        echo "==== install docker ====";
        
    apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D
    echo "deb https://apt.dockerproject.org/repo ubuntu-trusty main" > /etc/apt/sources.list.d/docker.list
    apt-get update
    apt-get install -y linux-image-extra-$(uname -r) apparmor docker-engine       
    
        echo "==== docker group ====";
    # https://docs.docker.com/engine/installation/linux/ubuntulinux/#create-a-docker-group    
    groupadd docker
    
        echo "==== run docker service ====";
        
    service docker start
    
        echo "==== status docker service ====";
        
    service docker status
    
        echo "==== docker add group ====";
    usermod -aG docker ubuntu
    usermod -aG docker vagrant
    source ~/.bashrc
    
        echo "==== restart all vagrant ssh sessions ====";
        # https://github.com/mitchellh/vagrant/issues/3998#issuecomment-60359659
    ps aux | grep 'sshd:' | awk '{print $2}' | xargs kill
    
        echo "==== docker test as vagrant user ====";
    
    sudo -u vagrant docker run hello-world
    
    echo "---------------- end --------------- ^^^";
  SHELL
end