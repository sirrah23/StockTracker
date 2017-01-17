Vagrant.configure("2") do |config|
  config.vm.box = "PHPBox"
  config.vm.network :forwarded_port, guest: 80, host: 8080
  config.ssh.username = 'vagrant'
  config.ssh.password = 'vagrant'
  config.vm.synced_folder "./", "/vagrant", "owner": "root", group:"root"
end
