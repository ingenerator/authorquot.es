#
# Cookbook Name:: authorquotes
# Attributes:: dev-server
#
# Default configurations for recipes that require dev-server roles

default['authorquotes']['http_port'] = 80
default['authorquotes']['site']['host']    = 'authorquotes.dev'
default['authorquotes']['site']['docroot'] = '/var/www/authorquot.es/htdocs'
default['authorquotes']['site']['contact'] = 'andrew@ingenerator.com'
default['authorquotes']['site']['aliases'] = ''
default['authorquotes']['site']['expires_active'] = 'On'
default['authorquotes']['site']['log_level'] = 'emerg'
default['authorquotes']['site']['front_controller'] = 'index.php'
default['authorquotes']['site']['allow_override'] = 'all'