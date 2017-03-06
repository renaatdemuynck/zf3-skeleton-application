# -*- mode: ruby -*-
# vi: set ft=ruby :

# https://docs.vagrantup.com.

Vagrant.configure('2') do |config|
  
  # Use official Ubuntu Server 14.04 LTS (Trusty Tahr)
  config.vm.box = 'ubuntu/trusty64'
  
  # Forward host port 8080 to guest port 80
  config.vm.network :forwarded_port, guest: 80, host: 8080
  
  # Run shell script to set up the server
  config.vm.provision :shell do |s|
    s.env = {APPLICATION_ENV:ENV['APPLICATION_ENV']}
    s.inline = <<-SHELL
      
      # Install Apache 2.4 and PHP 5.6
      add-apt-repository -y ppa:ondrej/php
      apt-get update -qq
      apt-get install -y apache2
      apt-get install -y php5.6
      
      # Install MySql
      DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server
      
      # Enable Apache rewrite module
      a2enmod rewrite
      
      # install extra PHP modules
      apt-get install -y php5.6-intl
      apt-get install -y php5.6-mysql
      
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
  
  config.vm.provision :shell, path: "bin/install.sh"
  
end
