#
# Report: awesome.
#
# @author Luke Carrier <luke@carrier.im>
# @copyright (c) 2014 Luke Carrier
#

.PHONY: all clean

TOP := $(dir $(CURDIR)/$(word $(words $(MAKEFILE_LIST)), $(MAKEFILE_LIST)))

all: build/report_awesome.zip

clean:
	rm -rf $(TOP)build

build/report_awesome.zip:
	mkdir -p $(TOP)build
	cp -rv $(TOP)src $(TOP)build/awesome
	cp $(TOP)README.md $(TOP)build/awesome/README.txt
	cd $(TOP)build \
	    && zip -r report_awesome.zip awesome
	rm -rfv $(TOP)build/awesome
