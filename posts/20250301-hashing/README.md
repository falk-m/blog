---
title: 'how hashing works'
taxonomy:
    tag:
        - OTHER
date: '2025-03-01'
---

It is hard to discripe concepts like blockchains or digital signatures, without to describe the fundamental concepts of hash-functions.
On the future I can refer to this post:-)

## What is it?

A hash function produces to every input a pseudo random output.    
What does this mean?    
Imagine there is a black box.    
You can insert a book and the black box replay to you the EAN Number of the book.
When you insert Harry Potter 1, the output is 123456. Every time you insert this book, the output is the same, 123456.
You can also go to the library and insert another sample of Harry Potter 1, the black box outputs 123456.
When you insert Harry Potter 2, the number is a completely other number, like 232323. 

## Properties and benefits

- the output of the hash function has always the same length, like 32byte
- deterministic: the same input produces the same hash
- little changes on the input data changes the hash totally
- collision resistance: it is almost impossible to find two different inputs that produces the same hash output
- the hash doesn't get information about the input data, it's impossible to rebuild the input data from the hash

## Examples

- md5('example data') = 5c71dbb287630d65ca93764c34d9aa0d
- md5('example data2') = f34a69227b6f859b17d04538a3e09b1a
- md5('very very very very very very very very very long text') = bd85213847b18aa9f2ee8d3c39ba1e43

## When is it used?

- Password logins
  - by the registration process is the hash of the password stored and not the password in clear text: hash('secret') is stored in db
  - by login, the system build the hash of the input password and compare this hash with the stored hash
- Checksums
  - build the hash of a file, called checksum: hash([very large file])
  - the receiver of the file can compare the checksum with the received file and detect if the file is corrupted or changed
- Blockchains
  - every block contains the hash from the previous block
  - nobody can change some past block without change all following blocks
- ...

## Let's build a hash

This is an example. It's similar to md5 or sha1 algotohems, but very simplified.
We calculate a hash of a length of 4byte.

### Excursion: bit operations

AND (&): return 1, when both compared bits are 1

OR (|): return 1 then one or both input bits are 1

XOR (^): return 1, when the input bits are not equal

NOT (~): return 1, when the input is 0, and 0 when the input is 1

| A | B | A & B | A \| B | A ^ B | ~A
|---|---|---|----|---|---|
| 0 | 0 | 0 | 0  | 0 | 1 |
| 1 | 0 | 0 | 1  | 1 | 0 |
| 0 | 1 | 0 | 1  | 1 | 1 |
| 1 | 1 | 1 | 1  | 0 | 0 |

ADD (+): add to numbers

Example 7 + 2 = 9
| A | B | overhang | Result |
|---|---|---|----|
| 1 | 0 | 0 | 1 |
| 1 | 1 | 1 | 0 |
| 1 | 0 | 1 | 0 |
| 0 | 0 | 0 | 1 |


### build input binary representation

Let's start with the input. We want a hash for the string 'secret'

First we look for the ASCII representation for each letter.

s = 115, e = 101, c = 99, r = 114, e = 101, t = 116

Then we look for the binary representation of these numbers.

115 = 01110011, 101 = 01100101, 99 = 01100011, 114 = 01110010, 101 = 01100101, 116 = 01110100

Now we have built the binary representation of the word 'secret':    
01110011 01100101 01100011 01110010 01100101 01110100

When the input is too small, we append some zeros to fill them up to 64bits    
01110011 01100101 01100011 01110010 01100101 01110100 00000000 00000000

### initial block

Now we need 4 blocks with initial values.    
For these values we use the square root of 2.    
sqr(2) = 1.41421356237    
We split 4 decimals blocks: 41, 42, 13, 56     
The byte representation is 00101001 00101010 00001101 00101110

#### Block Rotating

We initial 4 binary Block with the initial values    
A = 00101001, B = 00101010, C = 00001101, D= 00101110

Now we run a loop for each input byte (means 8 times).

FOR i = 0 TO i = 7    
A_next = D    
B_next = rotate(A + F(B,C,D,i) + input(i), i)    
C_next = B    
D_next = C    

input(i) returns the i-th byte from the input.    
e.g. input(0) =  01110011

rotate(bites, i) cut the first i bites from the first parameter and append then to the end of them.    
e.g. rotate(11110000, 2) = 11000011

F is the formation function.    
Depends on the iteration number i, when they are even or odd, there are different formations:    
F(b1,b2,b3,i) = when i % 2 = 0 then ((b1 & b2) | ((~b1) & b3)) else (b1 ^ ( b2 | (~b3)))

### run the example

**iteration 1**

i = 0    
A = 00101001, B = 00101010, C = 00001101, D= 00101110    

A_next = D = 00101110    
C_next = B = 00101010    
D_next = C = 00001101    
input(i) = input(0) = 01110011

F(B,C,D,i) = F(00101010,00001101,00101110,0) = ((B & C) | ((~B) & D))    
 = ((00101010 & 00001101) | ((~00101010) & 00101110))    
 = (00001000 | (11010101 & 00101110)) = (00001000 | 00000100) = 00001100    
A + F(B,C,D,i) + input(i) = 00101110 + 00001100 + 01110011 = 10101101    
B_next = rotate(A + F(B,C,D,i) + input(i), i) = 10101101  

**iteration 2**

i = 1    
A = 00101110, B = 10101101, C = 00101010, D= 00001101  

A_next = D = 00001101    
C_next = B = 10101101    
D_next = C = 00101010  
input(i) = input(1) = 01100101

F(B,C,D,i) = F(10101101,00101010,00001101,1) = (b1 ^ ( b2 | (~b3)))    
(10101101 ^ ( 00101010 | (~00001101))) = (10101101 ^ ( 00101010 | 11110010))    
= 10101101 ^ 11111010 = 10101000    
A + F(B,C,D,i) + input(i) = 00101110 + 10101000 + 01100101 = 00111011    
B_next = rotate(A + F(B,C,D,i) + input(i), i) = 01110110  

**iteration 3**

i = 2   
A = 00001101, B = 01110110, C = 10101101, D= 00101010  

A_next = D = 00101010    
C_next = B = 01110110    
D_next = C = 10101101    
input(i) = input(2) = 01100011

F(B,C,D,i) = F(01110110,10101101,00101010,2) = ((B & C) | ((~B) & D))   
= 00100100 | (10001001 & 00101010) = 00100100 | 00001000 = 00101100    
A + F(B,C,D,i) + input(i) = 00001101 + 00101100 + 01100011 = 10011100    
B_next = rotate(A + F(B,C,D,i) + input(i), i) = 01110010 

**iteration 4**

i = 3   
A = 00101010, B = 01110010, C = 01110110, D= 10101101  

A_next = D = 10101101    
C_next = B = 01110010    
D_next = C = 01110110    
input(i) = input(3) = 01110010

F(B,C,D,i) = F(01110010,01110110,10101101,3) = (b1 ^ (b2 | (~b3)))   
= 01110010 ^ (01110110 | 01010010) = 01110010 ^ 01110110 = 01110010    
A + F(B,C,D,i) + input(i) = 00101010 + 01110010 + 01110010 = 00001110    
B_next = rotate(A + F(B,C,D,i) + input(i), i) = 01110000

### Result

I abbreviate the result hash is A B C D = 10101101 01110000 01110010 01110110

So the hash of the word 'secret' is [173] p r v.    
ASCII code 173 is a non-printing character also known as the soft hyphen.

## Link

- [How the MD5 hash function works (from scratch)](https://www.youtube.com/watch?v=5MiMK45gkTY)
- [SHA-256 | COMPLETE Step-By-Step Explanation](https://www.youtube.com/watch?v=orIgy2MjqrA&si=EaHWJ6l1hfU3FOvM)