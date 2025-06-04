// numberConverter.js
import { toWords } from 'node_modules/to-words/dist\ToWords.js';

export function convertNumber(num) {
    return toWords(num);
}
