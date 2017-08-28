# -*- mode: ruby -*-
# vi: set ft=ruby :

# https://docs.vagrantup.com.

Vagrant.configure('2') do |config|
  
  # Use official Ubuntu 16.04 LTS (Xenial Xerus)
  config.vm.box = 'ubuntu/xenial64'
  
  # Forward host port 8080 to guest port 80
  config.vm.network :forwarded_port, guest: 80, host: 8080
  
  # Run shell script to set up the server
  config.vm.provision 'bootstrap', type: 'shell' do |s|
    s.env = {APPLICATION_ENV:ENV['APPLICATION_ENV']}
    s.inline = <<-SHELL
    
      # Make debconf use a frontend that expects no interactive input
      export DEBIAN_FRONTEND=noninteractive
      
      # Install Apache, MySql and PHP
      apt-get -y install apache2
      apt-get -y install mysql-server
      apt-get -y install php
      apt-get -y install libapache2-mod-php
      apt-get -y install php-intl
      apt-get -y install php-mysql
      apt-get -y install php-zip
      apt-get -y install php-dom
      apt-get -y install php-mbstring
      
      # Create database user
      echo "Creating database user for remote management..."
      mysql -u root <<-"SQL"
				CREATE USER IF NOT EXISTS `vagrant`@`%` IDENTIFIED BY "vagrant";
				GRANT ALL PRIVILEGES ON *.* TO `vagrant`@`%`;
			SQL
      
      # Install Composer globally
      echo "Install Composer globally..."
      curl -sS https://getcomposer.org/installer | php
      mv composer.phar /usr/local/bin/composer
      
      # Force Composer to generate .BAT proxy files
      composer config -g bin-compat full
      
      # Enable Apache rewrite module
      a2enmod rewrite
      
      # Create new site config file
      cat > /etc/apache2/sites-available/zf3-skeleton-application.conf <<-EOF
				<VirtualHost *:80>
				    
				    # Set the server name
				    ServerName localhost
				    
				    # Set the root to the Vagrant shared folder
				    DocumentRoot /vagrant/public
				    
				    <Directory '/vagrant/public'>
				        AllowOverride All
				        Require all granted
				    </Directory>
				    
				    # Set log file location
				    ErrorLog /vagrant/data/logs/apache_error.log
				    CustomLog /vagrant/data/logs/apache_access.log combined
				    
				    # Set application environment
				    SetEnv APPLICATION_ENV $APPLICATION_ENV
				    
				</VirtualHost>
			EOF
      
      # Enable the new site
      a2dissite 000-default
      a2ensite zf3-skeleton-application
      
    SHELL
  end
  
  config.vm.provision 'install', type: 'shell', path: 'bin/install.sh', upload_path: '/vagrant/bin/install.sh'
  
  # Run shell script to set up the server
  config.vm.provision 'shell', run: 'always' do |s|
    s.inline = <<-SHELL
      
      # (Re)start Apache
      service apache2 restart
      
    SHELL
  end
  
end
