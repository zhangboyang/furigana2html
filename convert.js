"use strict";

function parse(s) {
    let gen = function* () {
        for (let ch of s) {
            yield ch;
        }
    }();
    let until = function (sep) {
        let text = [];
        for (;;) {
            let ch = gen.next().value;
            if (ch === undefined || sep.includes(ch)) {
                return { token: ch, text: text };
            }
            text.push(ch);
        }
    }
    let result = [];
    let emit = function (text, kana) {
        if (text.length > 0) {
            result.push({ text: text.join(""), kana: kana.join("") });
        }
    }
    for (;;) {
        let chunk = until("\n[(");
        if (chunk.token === undefined) break;
        let buffer;
        switch (chunk.token) {
        case '\n':
            emit(chunk.text, []);
            emit([chunk.token], []);
            continue;
        case '[':
            emit(chunk.text, []);
            buffer = until("]").text;
            until("(");
            break;
        case '(':
            buffer = [chunk.text.pop()]
            emit(chunk.text, []);
            break;
        }
        emit(buffer, until(")").text);
    }
    return result;
}

function render_plain(indata) {
    return indata.map(x => x.text).join("");
}

function render_ruby(indata) {
    let out = [];
    for (let chunk of indata) {
        //chunk.text = chunk.text.replace(/　/g, '&emsp;');
        if (chunk.kana !== "") {
            out.push("<ruby><rb>" + chunk.text + "</rb><rt>" + chunk.kana + "</rt></ruby>");
        } else {
            switch (chunk.text) {
            case '\n': chunk.text = "<br>\n"; break;
            }
            out.push(chunk.text);
        }
    }
    return out.join("");
}

function render_wiki(indata) {
    let out = [];
    for (let chunk of indata) {
        if (chunk.kana !== "") {
            out.push("{{ruby|" + chunk.text + "|" + chunk.kana + "}}");
        } else {
            out.push(chunk.text);
        }
    }
    return out.join("");
}



const fs = require('fs');
const path = require('path');
if (process.argv.length <= 3) {
    process.stdout.write("usage:\n  " + process.argv.slice(0, 2).map(x => path.basename(x)).join(" ") + " [FORMAT] [FILE]\n");
    process.exit(0);
}
let outformat = process.argv[2];
let filename = process.argv[3];
let intext = fs.readFileSync(filename, {encoding:'utf8', flag:'r'}); 
let indata = parse(intext);
let outtext;
switch (outformat) {
case "plain": outtext = render_plain(indata); break;
case "ruby": outtext = render_ruby(indata); break;
case "wiki": outtext = render_wiki(indata); break;
default: outtext = "unknown output format: " + outformat;
}
process.stdout.write(outtext);
