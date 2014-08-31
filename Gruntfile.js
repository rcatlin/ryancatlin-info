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
                    'js/bootstrap.min.js': 'bootstrap/dist/js/bootstrap.min.js',
                    'js/summernote.min.js': 'summernote/dist/summernote.min.js',
                    'js/ready.min.js': 'domready/ready.min.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.min.css': 'bootstrap/dist/css/bootstrap.min.css',
                    'css/bootstrap-theme.min.css': 'bootstrap/dist/css/bootstrap-theme.min.css',
                    'css/font-awesome.min.css': 'fontawesome/css/font-awesome.min.css',
                    'css/summernote.css': 'summernote/dist/summernote.css',
                    'css/main.css':'../src/MyProject/Bundle/MainBundle/Resources/public/css/main.css',
                }
            },
            fonts: {
                files: {
                    'fonts': [
                        'bootstrap/dist/fonts',
                        'fontawesome/fonts'
                    ],
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
