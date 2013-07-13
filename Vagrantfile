# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  # All Vagrant configuration is done here. The most common configuration
  # options are documented and commented below. For a complete reference,
  # please see the online documentation at vagrantup.com.

  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "precise32"

  # The url from where the 'config.vm.box' box will be fetched if it
  # doesn't already exist on the user's system.
  config.vm.box_url = "http://files.vagrantup.com/precise32.box"

  # Performance enhancements from http://blog.jdpfu.com/2012/09/14/solution-for-slow-ubuntu-in-virtualbox
  # ** Fixed storage allocation

  # Chipset ICH9
  config.vm.customize ["modifyvm", :id, "--chipset", "ich9"]
  # IO APIC On
  config.vm.customize ["modifyvm", :id, "--ioapic", "on"]
  # 3D acceleration off
  config.vm.customize ["modifyvm", :id, "--accelerate3d", "off"]

  # Boot with a GUI so you can see the screen. (Default is headless)
   config.vm.boot_mode = :gui

  # Assign this VM to a host-only network IP, allowing you to access it
  # via the IP. Host-only networks can talk to the host machine as well as
  # any other machines on the same network, but cannot be accessed (through this
  # network interface) by any external networks.
  config.vm.network :hostonly, "10.10.10.11"
  config.vm.host_name = "authorquotes.dev"

  # Assign this VM to a bridged network, allowing you to connect directly to a
  # network using the host's network device. This makes the VM appear as another
  # physical device on your network.
  # config.vm.network :bridged

  # Forward a port from the guest to the host, which allows for outside
  # computers to access the VM, whereas host only networking does not.
  # config.vm.forward_port 80, 8080

  # Share an additional folder to the guest VM. The first argument is
  # an identifier, the second is the path on the guest to mount the
  # folder, and the third is the path on the host to the actual folder.

  # Enable provisioning with chef solo, specifying a cookbooks path, roles
  # path, and data_bags path (all relative to this Vagrantfile), and adding
  # some recipes and/or roles.
  #
  config.vm.provision :chef_solo do |chef|

  chef.cookbooks_path = "architecture/cookbooks"
  chef.roles_path = "architecture/roles"
  chef.data_bags_path = "architecture/data_bags"

  chef.add_role "dev-server"
  end

end
