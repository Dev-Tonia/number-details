## HNG12 Number Details API

This is a simple PHP API that classifies numbers based on their properties (Armstrong, Prime, Perfect, Odd/Even) and provides fun facts about them.

### Features

- Check if a number is **Armstrong** (Narcissistic)
- Check if a number is **Prime**
- Check if a number is **Perfect**
- Determine if the number is **Odd or Even**
- Get a **fun fact** about the number from [Numbers API](http://numbersapi.com/)

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/Dev-Tonia/number-details.git
   cd number-details
   ```

2. make sure you have php installed on your machine
3. Start the development server:

### API Endpoint:

```typescript
GET /api/classify-number?number=<number>
```

`

### Example Response:

```json
{
  "number": 371,
  "is_prime": false,
  "is_perfect": false,
  "properties": ["armstrong", "odd"],
  "digit_sum": 11,
  "fun_fact": "371 is an Armstrong number because 3^3 + 7^3 + 1^3 = 371"
}
```

#### API Logic

- **Armstrong Number**: Sum of its digits raised to the power of the number of digits equals the number.
- **Prime Number**: Only divisible by 1 and itself.
- **Perfect Number**: Sum of divisors (excluding itself) equals the number.
- **Even/Odd**: Based on divisibility by 2.

#### Security & Restrictions

- Only accessible via /api/classify-number
- Returns 404 if accessed via any other route
- Validates that input is a positive integer

##### 📄 License

MIT License - Free to use and modify.
