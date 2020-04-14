# Genetic algorithm.
A genetic algorithm is a metaheuristic inspired by the process of natural selection that belongs to 
the larger class of evolutionary algorithms. Genetic algorithms are commonly used to generate high-quality
solutions to optimization and search problems by relying on biologically inspired operators such as mutation,
crossover and selection. John Holland introduced genetic algorithms in 1960 based on the concept of Darwin’s theory
of evolution; his student David E. Goldberg further extended genetic algorithm in 1989.

You can read more about this algorithm in [wikipedia](https://en.wikipedia.org/wiki/Genetic_algorithm)

# Disclaimer.
First of all, it is a training project. The main goal is to understand the genetic algorithm a bit more and to have a little fun.
So, I did not seek to make it super optimal or something like that. Anyway, I am open to your suggestions :)

This moment there are two ways to use this implementation:
* Canonical example of evolution from a random set of characters to the target string.
* More useful example is finding extremes of functions.

The good piece of news is - you can use the algorithm for your own goals implementing AbstractDNA and AbstractGene

# Usage.
1. String evolution.

Suppose you want to get the `Where is the money, Lebowski?`. Lets define it:
```php
  $goal       = 'Where is the money, Lebowski?';
```
Then, you need to instantiate Population object with StringDNA.
Feel free to pick population number and mutation rate parameters. 
It's very interesting to see how the result will change depending on these parameters.

```php
  $DNA        = new ASCIIStringDNA($goal);
  $population = new Population($DNA, $populationNumber = 200, $mutationRate = 0.1);
```

The main process takes place here. You need to evaluate a fitness of population and create new generation until you get your goal.

```php
  $bestOfEveryGeneration = []
  while ($population->getBest()->getValue() !== $goal) {
      $population->evaluateFitness();
      $population->createNewGeneration();
      $bestOfeveryGeneration[] = $population->getBest()->getValue();
  }
  ```

Then you can analyse the result:
```php
$epoch = $population->getEpoch();
$yourGoal = $population->getBest()->getValue();
$evolutionString = implode(", " $bestOfeveryGeneration);
```

2. Find extreme of a function.

Suppose you want to find a max of following function: `5 + 3x - 4y - x^2 + x y - y^2`.  
Where x in [-2; 2] and y in [-2, 2].


Firstly you need to implement a callable function that will evaluate your equation.
This callable should return the calculation result.

```php
 $function = function (...$args) {
      $x = func_get_arg(0);
      $y = func_get_arg(1);

      $equation = 5 + 3 * $x - 4 * $y - $x ** 2 + $x * $y - $y ** 2;

      return $equation;
  }
```
            
Then, let's wrap this function to Equation instance:
```php
$equation = new Equation($function);
```

And finally, you need to instantiate a Math DNA. 
* The first argument is $equation object itself.
* The second argument is an array of math genes where every gene corresponds to an equation variable.
In turn, every variable has its own boundaries.
* Bool value indicates max or min of the equation is interesting for you.
```php
  $mathDNA = new MathDNA($equation, [new MathGene(-2, 2), new MathGene(-2, 2)], true);
```
And then again you need to evaluate a fitness of population and create new generations.  
Feel free to experiment here.

```php
  $population = new Population($DNA, $populationNumber = 200, $mutationRate = 0.1);

  for ($i = 0; $i < 100; $i++) {
      $population->evaluateFitness();
      $population->createNewGeneration();
  }

  /** @var MathGene[] $bestValue */
  $bestValue = $population->getBest()->getValue();
```

Then you can analyze the result.  
The "bestValue" will contain array with math genes where every gene is an answer of your equation
```php
/** @var MathGene[] $bestValue */
$bestValue = $population->getBest()->getValue();
```
You can find more detailed examples in the tests directory of this repository.

# Credits
Feel free to ask any questions or make suggestions in issue.   
I hope this repository will be useful for you.
