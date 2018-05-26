# Python3

import os
import math
import random

# Values to change and save for each loop turn
temp = 22
hum = 30
qua = 400

# Time counter
time = 0

# Originial values
tempO = 22
humO = 30
quaO = 400

# Random value bounds to add to or subtract from current values
tempRan = 3
humRan = 10
quaRan = 20

# Shift index for sin jumps
move = 8

# 1 day is 1440 minute
theEnd = 1440

# Properties for each type as time interval, value difference, pollution and fresh times
tempPeriod = 120
tempChange = 12
tempDirty = 30
tempClean = 10

humPeriod = 160
humChange = 60
humDirty = 45
humClean = 15

quaPeriod = 144
quaChange = 100
quaDirty = 54
quaClean = 18

# Open Json file and put start string
file = open('aa.json', 'w')

file.write('[\n')

# Create all values for a week
for m in range(0, theEnd * 7):

    # Index counter for each day
    i = m % theEnd

    # Day counter
    n = int(m / theEnd)

    # Temp
    if (i % tempPeriod > n * move and i % tempPeriod <= tempDirty + n * move):

        temp = tempO + int(tempChange*math.sin(math.pi/2/tempDirty*(i%tempPeriod-n*move)))

    elif (i % tempPeriod > tempDirty + n * move and i % tempPeriod <= tempDirty + tempClean + n * move):

        temp = tempO + tempChange - int(tempChange*math.sin(math.pi/2/tempClean*(i%tempPeriod-tempDirty-n*move)))

    else:
        temp = tempO + random.randint(-tempRan, tempRan);
    
    # Hum
    if (i % humPeriod > n * move and i % humPeriod <= humDirty + n * move):

        hum = humO + int(humChange*math.sin(math.pi/2/humDirty*(i%humPeriod-n*move)))

    elif (i % humPeriod > humDirty + n * move and i % humPeriod <= humDirty + humClean + n * move):

        hum = humO + humChange - int(humChange*math.sin(math.pi/2/humClean*(i%humPeriod-humDirty-n*move)))
    else:
        hum = humO + random.randint(-humRan, humRan)

    # Qua
    if (i % quaPeriod > n * move and i % quaPeriod <= quaDirty + n * move):

        qua = quaO + int(quaChange*math.sin(math.pi/2/quaDirty*(i%quaPeriod-n*move)))

    elif (i % quaPeriod > quaDirty + n * move and i % quaPeriod <= quaDirty + quaClean + n * move):

        qua = quaO + quaChange - int(quaChange*math.sin(math.pi/2/quaClean*(i%quaPeriod-quaDirty-n*move)))
    else:
        qua = quaO + random.randint(-quaRan, quaRan)

    # Write all new values into file
    file.write('\t{\n')

    file.write('\t\t"temp" : ' + str(temp) + ',\n')

    file.write('\t\t"hum" : ' + str(hum) + ',\n')

    file.write('\t\t"quality" : ' + str(qua) + ',\n')

    file.write('\t\t"timestamp" : ' + str(time))

    file.write('\n\t},\n')

    # Move time
    time = time + 60

# Close file, note that you may need to erase last ',' by hand
file.write(']')

file.close()
