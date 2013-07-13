#
# Cookbook Name:: authorquotes
# Recipe:: virtual-host
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
# Provisions an apache virtual host for the currently deploying site

sites = {
  :http => {
    'port' => node['authorquotes']['http_port'],
    'name' => node['authorquotes']['site']['host']
  }
}

sites.each do | proto, host_config |

  # Build the HTTP web app config
  web_app host_config['name'] do
    template         'authorquotes.conf.erb'
    server_name      node['authorquotes']['site']['host']
    docroot          node['authorquotes']['site']['docroot']
    port             host_config['port']
    contact          node['authorquotes']['site']['contact']
    server_aliases   node['authorquotes']['site']['aliases']
    expires_active   node['authorquotes']['site']['expires_active']
    log_level        node['authorquotes']['site']['log_level']
    front_controller node['authorquotes']['site']['front_controller']
    allow_override   node['authorquotes']['site']['allow_override']
  end

end


