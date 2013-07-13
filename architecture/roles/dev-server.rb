# Dev-servers are a standalone app-server

name "dev-server"
description "Server instances for developing on"

run_list(
  "recipe[authorquotes::dev-server]"
)

override_attributes({
  'apache' => {
    'prefork' => {
       'startservers' => 5,
       'minspareservers' => 5,
       'maxspareservers' => 5,
       'serverlimit'     => 5,
       'maxclients'      => 5,
       'maxrequestsperchild' => 0
    },
  },
  'authorquotes' => {
    'site' => {
      'host' => 'authorquot.es',
      'aliases' => [],
      'docroot' => '/var/www/authorquot.es/htdocs',
      'log_level' => 'info',
	  'front_controller' => 'index.php',
	  'allow_override' => 'all'
    },
  },
    'default_modules' => ['status','alias','auth_basic','authn_file',
       'authz_default','authz_groupfile','authz_host','authz_user',
       'autoindex','dir','env','mime','negotiation','setenvif','php5',
       'rewrite'],
    'serversignature' => 'Off',
    'traceenable' => 'Off',
    'default_site_enabled' => false
  }
)