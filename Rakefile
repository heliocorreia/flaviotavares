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

desc "Start everything."
multitask :start => ['mysql:start', 'compass:watch']

desc "Stop everything."
multitask :stop => ['mysql:stop']
