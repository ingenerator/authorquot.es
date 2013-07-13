#
# Cookbook Name:: php
# Definition:: php_module_config
#
# Copyright 2012 inGenerator Ltd.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#
# Configures a PHP module (by including a php::module_xxxx recipe) and 
# provisions a module ini file. Default config for each ini file should be
# set in the appropriate attributes file. They can be parsed from the plaintext
# of the PHP man page with \^(\w+)\.([^\t]+)\t"?([^\t^"]+)"?.*$\ and replaced
# out using default['php']['modules']['$1']['ini']['$2'] = '$3'

define :php_module do
  
  module_name = params[:name]
  
  # Include the recipe
  if params[:recipe_name]
    recipe = params[:recipe_name]
  else
    recipe = "php::module_#{module_name}"
  end
  
  include_recipe recipe

  # Load module configuration from the node attributes (or empty)
  mod_config = node['php']['modules'][module_name]

  if mod_config.nil?
    mod_config = { 'as_zend_extension' => false, 'ini' => {} }
  end
    
  if mod_config['as_zend_extension']
    extension_name = "#{node['php']['ext_dir']}/#{module_name}.so"
  else
    extension_name = "#{module_name}.so"
  end

  # Provision the config file
  template "#{node['php']['ext_conf_dir']}/#{module_name}.ini" do
    source "php_module.ini.erb"
    cookbook "php"
    owner "root"
    group "root"
    mode 0644
    variables({
      :extension => extension_name,
      :module_name => module_name,
      :ini_vars => mod_config['ini'].to_hash,
      :as_zend_extension => mod_config['as_zend_extension']
    })
    notifies :restart, "service[apache2]"
  end
end
