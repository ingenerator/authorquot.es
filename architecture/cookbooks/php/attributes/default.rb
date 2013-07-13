#
# Author:: Seth Chisamore (<schisamo@opscode.com>)
# Cookbook Name:: php
# Attribute:: default
#
# Copyright 2011, Opscode, Inc.
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

lib_dir = kernel['machine'] =~ /x86_64/ ? 'lib64' : 'lib'

default['php']['install_method'] = 'package'
default['php']['directives'] = {}

case node["platform_family"]
when "rhel", "fedora"
  default['php']['conf_dir']      = '/etc'
  default['php']['ext_conf_dir']  = '/etc/php.d'
  default['php']['fpm_user']      = 'nobody'
  default['php']['fpm_group']     = 'nobody'
  default['php']['ext_dir']       = "/usr/#{lib_dir}/php/modules"
  if node['platform_version'].to_f < 6 then
    default['php']['packages'] = ['php53', 'php53-devel', 'php53-cli', 'php-pear']
  else
    default['php']['packages'] = ['php', 'php-devel', 'php-cli', 'php-pear']
  end
when "debian"
  default['php']['conf_dir']      = '/etc/php5/cli'
  default['php']['ext_conf_dir']  = '/etc/php5/conf.d'
  default['php']['fpm_user']      = 'www-data'
  default['php']['fpm_group']     = 'www-data'
  default['php']['ext_dir']       = "/usr/#{lib_dir}/php5/20090626+lfs"
  default['php']['packages']      = ['php5-cgi', 'php5', 'php5-dev', 'php5-cli', 'php-pear']
else
  default['php']['conf_dir']      = '/etc/php5/cli'
  default['php']['ext_conf_dir']  = '/etc/php5/conf.d'
  default['php']['fpm_user']      = 'www-data'
  default['php']['fpm_group']     = 'www-data'
  default['php']['ext_dir']       = "/usr/#{lib_dir}/php5/20090626+lfs"
  default['php']['packages']      = ['php5-cgi', 'php5', 'php5-dev', 'php5-cli', 'php-pear']
end

default['php']['url'] = 'http://us.php.net/distributions'
default['php']['version'] = '5.3.10'
default['php']['checksum'] = 'ee26ff003eaeaefb649735980d9ef1ffad3ea8c2836e6ad520de598da225eaab'
default['php']['prefix_dir'] = '/usr/local'

default['php']['configure_options'] = %W{--prefix=#{php['prefix_dir']}
                                          --with-libdir=#{lib_dir}
                                          --with-config-file-path=#{php['conf_dir']}
                                          --with-config-file-scan-dir=#{php['ext_conf_dir']}
                                          --with-pear
                                          --enable-fpm
                                          --with-fpm-user=#{php['fpm_user']}
                                          --with-fpm-group=#{php['fpm_group']}
                                          --with-zlib
                                          --with-openssl
                                          --with-kerberos
                                          --with-bz2
                                          --with-curl
                                          --enable-ftp
                                          --enable-zip
                                          --enable-exif
                                          --with-gd
                                          --enable-gd-native-ttf
                                          --with-gettext
                                          --with-gmp
                                          --with-mhash
                                          --with-iconv
                                          --with-imap
                                          --with-imap-ssl
                                          --enable-sockets
                                          --enable-soap
                                          --with-xmlrpc
                                          --with-libevent-dir
                                          --with-mcrypt
                                          --enable-mbstring
                                          --with-t1lib
                                          --with-mysql
                                          --with-mysqli=/usr/bin/mysql_config
                                          --with-mysql-sock
                                          --with-sqlite3
                                          --with-pdo-mysql
                                          --with-pdo-sqlite}
# Default PHP config values
default['php']['config']['engine'] = 'On'
default['php']['config']['short_open_tag'] = 'On'
default['php']['config']['asp_tags'] = 'Off'
default['php']['config']['precision'] = '14'
default['php']['config']['y2k_compliance'] = 'On'
default['php']['config']['output_buffering'] = '4096'
default['php']['config']['zlib.output_compression'] = 'Off'
default['php']['config']['implicit_flush'] = 'Off'
default['php']['config']['unserialize_callback_func'] = ''
default['php']['config']['serialize_precision'] = '100'
default['php']['config']['allow_call_time_pass_reference'] = 'Off'
default['php']['config']['safe_mode'] = 'Off'
default['php']['config']['safe_mode_gid'] = 'Off'
default['php']['config']['safe_mode_include_dir'] = ''
default['php']['config']['safe_mode_exec_dir'] = ''
default['php']['config']['safe_mode_allowed_env_vars'] = 'PHP_'
default['php']['config']['safe_mode_protected_env_vars'] = 'LD_LIBRARY_PATH'
default['php']['config']['disable_functions'] = ''
default['php']['config']['disable_classes'] = ''
default['php']['config']['expose_php'] = 'On'
default['php']['config']['max_execution_time'] = '30'
default['php']['config']['max_input_time'] = '60'
default['php']['config']['memory_limit'] = '-1'
default['php']['config']['error_reporting'] = 'E_ALL & ~E_DEPRECATED'
default['php']['config']['display_errors'] = 'Off'
default['php']['config']['display_startup_errors'] = 'Off'
default['php']['config']['log_errors'] = 'On'
default['php']['config']['log_errors_max_len'] = '1024'
default['php']['config']['ignore_repeated_errors'] = 'Off'
default['php']['config']['ignore_repeated_source'] = 'Off'
default['php']['config']['report_memleaks'] = 'On'
default['php']['config']['track_errors'] = 'Off'
default['php']['config']['html_errors'] = 'Off'
default['php']['config']['variables_order'] = '"GPCS"'
default['php']['config']['request_order'] = '"GP"'
default['php']['config']['register_globals'] = 'Off'
default['php']['config']['register_long_arrays'] = 'Off'
default['php']['config']['register_argc_argv'] = 'Off'
default['php']['config']['auto_globals_jit'] = 'On'
default['php']['config']['post_max_size'] = '8M'
default['php']['config']['magic_quotes_gpc'] = 'Off'
default['php']['config']['magic_quotes_runtime'] = 'Off'
default['php']['config']['magic_quotes_sybase'] = 'Off'
default['php']['config']['auto_prepend_file'] = ''
default['php']['config']['auto_append_file'] = ''
default['php']['config']['doc_root'] = ''
default['php']['config']['user_dir'] = ''
default['php']['config']['enable_dl'] = 'Off'
default['php']['config']['file_uploads'] = 'On'
default['php']['config']['upload_max_filesize'] = '2M'
default['php']['config']['max_file_uploads'] = '20'
default['php']['config']['allow_url_fopen'] = 'On'
default['php']['config']['allow_url_include'] = 'Off'
default['php']['config']['default_socket_timeout'] = '60'
default['php']['config']['date.timezone'] = ''
default['php']['config']['define_syslog_variables'] = 'Off'
default['php']['config']['SMTP'] = 'localhost'
default['php']['config']['smtp_port'] = '25'
default['php']['config']['mail.add_x_header'] = 'On'
default['php']['config']['sql.safe_mode'] = 'Off'
default['php']['config']['odbc.allow_persistent'] = 'On'
default['php']['config']['odbc.check_persistent'] = 'On'
default['php']['config']['odbc.defaultlrl'] = '4096'
default['php']['config']['odbc.defaultbinmode'] = '1'
default['php']['config']['ibase.allow_persistent'] = '1'
default['php']['config']['mysqlnd.collect_statistics'] = 'On'
default['php']['config']['mysqlnd.collect_memory_statistics'] = 'Off'
default['php']['config']['pgsql.allow_persistent'] = 'On'
default['php']['config']['pgsql.auto_reset_persistent'] = 'Off'
default['php']['config']['pgsql.ignore_notice'] = '0'
default['php']['config']['pgsql.log_notice'] = '0'
default['php']['config']['sybct.allow_persistent'] = 'On'
default['php']['config']['sybct.min_server_severity'] = '10'
default['php']['config']['sybct.min_client_severity'] = '10'
default['php']['config']['bcmath.scale'] = '0'
default['php']['config']['pcre.backtrack_limit'] = 100000
default['php']['config']['pcre.recursion_limit'] = 100000
default['php']['config']['session.save_handler'] = 'files'
default['php']['config']['session.save_path'] = '/tmp'
default['php']['config']['session.use_cookies'] = '1'
default['php']['config']['session.use_only_cookies'] = '1'
default['php']['config']['session.name'] = 'PHPSESSID'
default['php']['config']['session.auto_start'] = '0'
default['php']['config']['session.cookie_lifetime'] = '0'
default['php']['config']['session.cookie_domain'] = ''
default['php']['config']['session.cookie_httponly'] = ''
default['php']['config']['session.serialize_handler'] = 'php'
default['php']['config']['session.gc_probability'] = '1'
default['php']['config']['session.gc_divisor'] = '1000'
default['php']['config']['session.gc_maxlifetime'] = '1440'
default['php']['config']['session.bug_compat_42'] = 'Off'
default['php']['config']['session.bug_compat_warn'] = 'Off'
default['php']['config']['session.referer_check'] = ''
default['php']['config']['session.entropy_length'] = '0'
default['php']['config']['session.entropy_file'] = ''
default['php']['config']['session.cache_limiter'] = 'nocache'
default['php']['config']['session.cache_expire'] = '180'
default['php']['config']['session.use_trans_sid'] = '0'
default['php']['config']['session.hash_function'] = '0'
default['php']['config']['session.hash_bits_per_character'] = '5'
default['php']['config']['mssql.allow_persistent'] = 'On'
default['php']['config']['mssql.min_error_severity'] = '10'
default['php']['config']['mssql.min_message_severity'] = '10'
default['php']['config']['mssql.compatability_mode'] = 'Off'
default['php']['config']['mssql.secure_connection'] = 'Off'
default['php']['config']['tidy.clean_output'] = 'Off'
default['php']['config']['soap.wsdl_cache_enabled'] = '1'
default['php']['config']['soap.wsdl_cache_ttl'] = '86400'
default['php']['config']['soap.wsdl_cache_limit'] = '5'
