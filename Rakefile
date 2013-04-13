task :default => [:help]

task :help do
end

namespace :mysql do
  task :start do
    system 'mysql.server start'
  end
  task :stop do
    system 'mysql.server stop'
  end
end

namespace :compass do
  task :compile do
    system 'compass compile -e production --force libs/sass/'
  end
  task :watch do
    system 'compass watch libs/sass/'
  end
end

namespace :locale do
  task :compile do
    system 'rmsgfmt languages/pt_BR.po -o languages/pt_BR.mo'
    system 'rmsgfmt languages/en_US.po -o languages/en_US.mo'
  end
end

namespace :deploy do
  task :prod do
    system "rsync --recursive --perms --force --delay-updates --compress --exclude-from=.rsync-exclude --human-readable --progress . #{ENV['USER']}@flaviotavares.com.br:/home/flaviotava/public_html/wp-content/themes/flaviotavares/"
  end
end

desc "Compile"
multitask :compile => ['compass:compile', 'locale:compile']

desc "Start everything."
multitask :start => ['mysql:start', 'compass:watch']

desc "Stop everything."
multitask :stop => ['mysql:stop']
