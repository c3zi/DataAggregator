How it works:
=============

1. Producer parses a content from text file and adds a new entry to the queue (RabbitMQ)
2. Consumer (there may be many consumers) runs every message from queue
3. Every message contains Facebook ID and script must download data from facebook's wall for the ID
4. Then data must be saved into the database
5. Then script has to generate a report about how many entries from facebook's wall was saved etc.