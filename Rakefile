task :default => :test

task :test do
  sh 'phpunit --colors --bootstrap test/TestHelper.php test'
end

task :doc do
  sh 'phpdoc -d lib -t docs -q --title "Calendar documentation" -o HTML:frames:DOM/earthli'
end