#
# Cookbook Name:: authorquotes
# Recipe:: php-standard
#
# Copyright 2012, inGenerator Ltd
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
# Provision and configure the PHP modules required in all environments

# Set the authorquotes standard PHP configuration
node.default['php']['config']['allow_call_time_pass_reference'] = 1
node.default['php']['config']['disable_functions'] = ''
node.default['php']['config']['enable_dl'] = 1
node.default['php']['config']['error_reporting'] = 'E_ALL'
node.default['php']['config']['expose_php'] = 0
node.default['php']['config']['html_errors'] = 1
node.default['php']['config']['mail.add_x_header'] = 0
node.default['php']['config']['memory_limit'] = '256M'
node.default['php']['config']['post_max_size'] = '30M'
node.default['php']['config']['request_order'] = ''
node.default['php']['config']['serialize_precision'] = 100
node.default['php']['config']['upload_max_filesize'] = '30M'
node.default['php']['config']['variables_order'] = 'EGPCS'
node.default['php']['config']['date.timezone'] = 'Europe/London'
node.default['php']['config']['pcre.backtrack_limit'] = 100000
node.default['php']['config']['session.bug_compat_warn'] = 1
node.default['php']['config']['session.gc_probability'] = 1
node.default['php']['config']['session.save_path'] = '/var/lib/php/session'

# Provision a single php.ini (this happens by default on rhel/fedora)
if ! platform_family?("rhel","fedora")
  # Set the location for the standard php.ini file
  node.override['php']['conf_dir'] = '/etc/php5'
end

# Install php and share config across cli, cgi and apache2
include_recipe("php")

# if ! platform_family?("rhel","fedora")
  # # Remove any environment-specific php.ini files that exist
  # # and replace with symlinks to the common config
  # %w(/etc/php5/cli/php.ini /etc/php5/apache2/php.ini /etc/php5/cgi/php.ini).each do |env_ini|

    # file env_ini do
      # action :delete
      # not_if do
        # File.symlink?(env_ini)
      # end
    # end

    # link env_ini do
     # # action :nothing
      # to "#{node['php']['conf_dir']}/php.ini"
      # not_if do
        # File.symlink?(env_ini)
      # end
     # # subscribes :create, resources(:recipe => "php"), :immediately
    # end
  # end
# end

# Install required PHP modules
