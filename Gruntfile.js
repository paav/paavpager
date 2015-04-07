module.exports = function(grunt) {
  grunt.initConfig({

    less: {
      main: {
        options: {
        },

        files: {
          'assets/main.css': 'less/main.less', 
        }
      },
    },

    watch: {
      less: {
        files: [
          'less/main.less',
        ],
        tasks: ['less:main'],
        options: {
          spawn: false,
        },
      },
    },
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');

  grunt.registerTask('default', ['watch']);
};

