# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  # All Vagrant configuration is done here. The most common configuration
  # options are documented and commented below. For a complete reference,
  # please see the online documentation at vagrantup.com.

  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "osn_dev"
  #config.vm.box = "osn_gearman" # problems with the cli
  #config.vm.box = "osn_gearman2"
  
  config.vm.customize [
    "modifyvm", :id,
    "--memory", "1000",
    "--cpus", "2"
  ]



  # Boot with a GUI so you can see the screen. (Default is headless)
  # config.vm.boot_mode = :gui

  # Assign this VM to a host-only network IP, allowing you to access it
  # via the IP. Host-only networks can talk to the host machine as well as
  # any other machines on the same network, but cannot be accessed (through this
  # network interface) by any external networks.
   config.vm.network :hostonly, "33.33.33.31"

  # Assign this VM to a bridged network, allowing you to connect directly to a
  # network using the host's network device. This makes the VM appear as another
  # physical device on your network.
  # config.vm.network :bridged

  # Forward a port from the guest to the host, which allows for outside
  # computers to access the VM, whereas host only networking does not.
  config.vm.forward_port 80, 8081
  config.vm.forward_port 3306, 3308
  config.vm.forward_port 27017, 27019
  #config.vm.forward_port 4730, 4732

  # Share an additional folder to the guest VM. The first argument is
  # an identifier, the second is the path on the guest to mount the
  # folder, and the third is the path on the host to the actual folder.
  # config.vm.share_folder "v-data", "/vagrant_data", "../data"
  #config.vm.share_folder("v-root", "/vagrant", ".", :owner => "www-data", :group => "www-data",:nfs => !RUBY_PLATFORM.downcase.include?("w32"))   

  config.vm.share_folder "v-root", "/vagrant", ".", :owner => "www-data", :group => "www-data" ,:extra => 'dmode=775,fmode=775'

  # "v-data", "/export", "/export", :owner=> 'vagrant', :group=>'httpd', :extra => 'dmode=775,fmode=775' 
 



end
