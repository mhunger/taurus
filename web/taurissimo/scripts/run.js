require('http');
const fs = require('fs');

fs.watch('.', {}, (eventType, filename) => {
    fs.open(filename, 'r', (err, fd) => {
        if(err) {
            if(err.code === "ENOENT") {
                console.log('file does not exist');
            } else {
                throw err;
            }
        } else {
            console.log('filename: [' + filename + ']')
            const PageConfig = require('./' + filename);
            var pageConfig = new PageConfig();
            console.log(pageConfig.getComponents());
        }
    })
});