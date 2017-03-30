# -*- mode: ruby -*-
# vi: set ft=ruby :

# https://docs.vagrantup.com.

Vagrant.configure('2') do |config|
  
  # Use official Ubuntu 16.04 LTS (Xenial Xerus)
  config.vm.box = 'ubuntu/xenial64'
  
  # Forward host port 8080 to guest port 80
  config.vm.network :forwarded_port, guest: 80, host: 8080
  
  # Run shell script to set up the server
  config.vm.provision :shell do |s|
    s.env = {APPLICATION_ENV:ENV['APPLICATION_ENV']}
    s.inline = <<-SHELL
      
      # Install Apache and PHP
      apt-get install -y apache2
      apt-get install -y php
      apt-get install -y libapache2-mod-php
      apt-get install -y php-intl
      apt-get install -y php-mysql
      apt-get install -y php-dom
            
      # Install MySql
      DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server
      
      # Create database user
      mysql -u root <<-SQL
				CREATE USER IF NOT EXISTS `vagrant`@`%` IDENTIFIED BY "vagrant";
				GRANT ALL PRIVILEGES ON *.* TO `vagrant`@`%`;
			SQL
      
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
      
      # (Re)start Apache
      service apache2 restart
      
    SHELL
  end
  
  config.vm.provision :shell, path: 'bin/install.sh'
  
end
