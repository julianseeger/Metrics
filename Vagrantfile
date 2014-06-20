# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "hashicorp/precise64"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 9080, host: 9080

  config.vm.provider :virtualbox do |vb|
    vb.gui = false
    vb.customize ["modifyvm", :id, "--memory", "2048"]
  end

  config.vm.provision :shell,
    inline: <<SCRIPT
      cd /vagrant
      apt-get update
      apt-get install -yqf python-software-properties make build-essential vim git libfontconfig htop
      add-apt-repository -y ppa:chris-lea/node.js
      add-apt-repository -y ppa:ondrej/php5
      apt-get update
      apt-get install -yqf ant nodejs php5 php5-cli php5-xsl
      su -l vagrant -c "sudo npm install -g yo grunt-cli bower"

      su -l vagrant -c "cd /vagrant && ant && cd /vagrant/build/dist && (./start.sh &)"
SCRIPT
end
