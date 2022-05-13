function test() {
    let a = 42 + 17;
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
    test();
}