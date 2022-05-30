function test()
    r = rand(1:1000)
    a = rand(1:1000)
    return r*a
end

function writeToFile(n)
    write("./write-test.txt", string(n, base = 10, pad = 1));
end

if length(ARGS) < 1
    print("missing param")
    exit(1)
end

arg = parse(Int64, ARGS[1])

if !isa(arg, Number) || arg < 1
    print("param not a number")
    exit(1)
end

for i = 1:arg
    b = i
    b += test()
    writeToFile(b)
end
