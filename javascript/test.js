const fs = require('fs');

function test() {
    let r = Math.floor(Math.random() * 1000) + 1;
    let a = Math.floor(Math.random() * 1000) + 1;
    return r * a;
}

function writeToFile(i) {
    try {
        fs.writeFileSync('./write-test.txt', i.toString());
    } catch (err) {
        console.error(err);
        process.exit(1);
    }
}

if (process.argv.length < 3) {
    console.error("missing param")
    process.exit(1);
}

if (isNaN(process.argv[2])) {
    console.error("param not a number")
    process.exit(1);
}

let arg = parseInt(process.argv[2]);
for (let i = 0; i < arg; i++) {
    let b = i;
    b *= test();
    writeToFile(b);
}