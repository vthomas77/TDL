# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "ubuntu/xenial64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  config.vm.box_check_update = true

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder "./back", "/var/www/html"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
    vb.memory = "2048"
  end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL
    cd /var/www/html/
    sudo apt-get update
    sudo apt-get install apache2 -y
    sudo cp apache2.conf /etc/apache2/
    sudo cp ports.conf /etc/apache2/
    sudo cp envvars /etc/apache2/
    sudo cp 000-default.conf /etc/apache2/sites-enabled/
    sudo ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
    sudo service apache2 restart
    sudo debconf-set-selections <<< "mysql-server-5.7 mysql-server/root_password password 0000"
    sudo debconf-set-selections <<< "mysql-server-5.7 mysql-server/root_password_again password 0000"
    sudo DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server-5.7
    sudo cp mysqld.cnf /etc/mysql/mysql.conf.d/
    sudo service mysql restart
    mysql -uroot -p0000 -e "GRANT ALL PRIVILEGES ON *.* TO root@'%' IDENTIFIED BY '0000'; FLUSH PRIVILEGES;"
    mysql -uroot -p0000 < /var/www/html/scriptdb.sql
    sudo add-apt-repository ppa:ondrej/php
    sudo apt-get update
    sudo apt-get install php7.2 -y
    sudo cp php.ini /etc/php/7.2/apache2/
    sudo service apache2 restart
    sudo apt-get install php7.2-mysql -y
    sudo apt-get install php7.2-common -y
    sudo apt-get install php7.2-mbstring -y
    sudo apt-get install php7.2-zip -y
    sudo apt-get install php7.2-xml -y
    sudo apt-get install libapache2-mod-php7.2 -y
    sudo apt-get update
    sudo service mysql restart
    sudo service apache2 restart
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    sudo mv composer.phar /usr/local/bin/composer
    sudo apt-get update
    sudo service apache2 restart
    composer create-project --prefer-dist laravel/lumen projetTDL
    sudo chmod 777 /var/www/html/projetTDL/storage/ -R
    sudo apt-get update
    sudo service mysql restart
    sudo service apache2 restart
    sudo apt-get check
    sudo apt-get update
    sudo apt-get upgrade -y
    sudo apt-get update
    clear
  SHELL
end
