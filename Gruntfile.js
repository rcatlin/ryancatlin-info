module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.min.js': 'jquery/dist/jquery.min.js',
                    'js/bootstrap.min.js': 'bootstrap/dist/js/bootstrap.min.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.min.css': 'bootstrap/dist/css/bootstrap.min.css',
                    'css/bootstrap-theme.min.css': 'bootstrap/dist/css/bootstrap-theme.min.css',
                    'css/main.css':'../src/MyProject/Bundle/MainBundle/Resources/public/css/main.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'bootstrap/dist/fonts'
                }
            }
        },
        copy: {
            images: {
                expand: true,
                cwd: 'src/MyProject/Bundle/MainBundle/Resources/public/images',
                src: '*',
                dest: 'web/assets/images/'
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.registerTask('default', ['bowercopy', 'copy']);
}
