# credit card fraud detection algorithm

#### This exercise is developed in Laravel and includes following:
A credit card transaction record is comprised of the following elements:

● Hashed credit card number

● Timestamp, of format: year-month-dayThour:minute:second

● Amount, of format: <dollars>.<cents>

Transaction records are stored as a comma-separated string of elements, for
example:
#### 10d7ce2f43e35fa57d1bbf8b1e2,2014-04-29T13:15:54,10.00

A credit card must be identified as fraudulent if the sum of amounts for a unique
hashed credit card number, for a period of time between X and Y, exceeds the
amount threshold Z.

Write a method which identifies fraudulent transactions and returns a list of their hashed
credit card numbers.

#### To test: run the unit test under test/Unit/FraudDetectionTest.php
