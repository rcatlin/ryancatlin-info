module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'app'
            },
            scripts: {
                files: {
                    'js/jquery.min.js': 'jquery/dist/jquery.min.js',
                    'js/bootstrap.min.js': 'bootstrap/dist/js/bootstrap.min.js',
                    'js/summernote.min.js': 'summernote/dist/summernote.min.js',
                    'js/ready.min.js': 'domready/ready.min.js',
                    'js/highlight.pack.js': 'highlightjs/highlight.pack.js',
                    'js/jquery-ui/ui/': 'jquery-ui/ui/minified/*.js',
                    'js/tag_autocomplete.js': '../src/js/tag_autocomplete.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.min.css': 'bootstrap/dist/css/bootstrap.min.css',
                    'css/bootstrap-theme.min.css': 'bootstrap/dist/css/bootstrap-theme.min.css',
                    'css/font-awesome.min.css': 'fontawesome/css/font-awesome.min.css',
                    'css/summernote.css': 'summernote/dist/summernote.css',
                    'css/main.css':'../src/css/main.css',
                    'css/highlightjs': 'highlightjs/styles/*.css',
                    'css/jquery-ui/themes/ui-lightness/': 'jquery-ui/themes/ui-lightness/*'
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
                cwd: 'src/img',
                src: '**',
                dest: 'app/img'
            },
            html: {
                expand: true,
                cwd: 'src/html',
                src: '**',
                dest: 'app'
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.registerTask('default', ['bowercopy', 'copy']);
}
