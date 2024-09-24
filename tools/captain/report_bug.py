#!/bin/env python3
import os
import glob

import argparse
parser = argparse.ArgumentParser(description='About this program')
parser.add_argument("bug_ids", help="Bug id to report", nargs="+")
parser.add_argument("--work_dir", default=f"{os.getcwd()}/workdir")
parser.add_argument("--debug", action="store_true")
args = parser.parse_args()

for target in glob.glob(f"{args.work_dir}/ar/aflplusplus/*"):
    if args.debug:
        print(f"[*] Found target: {target}")
    for put in glob.glob(f"{target}/*"):
        if args.debug:
            print(f"[*] Found PUT: {put}")
        for trial in glob.glob(f"{put}/*"):
            not_found = set(args.bug_ids)
            for monitor in glob.glob(f"{trial}/monitor/*"):
                with open(monitor, "r") as f:
                    # if args.debug:
                    #     print(f"[*] Reading monitor: {monitor}")
                    header = f.readline().strip()
                    if header:
                        header = header.split(",")
                        row = map(lambda x: int(x), f.readline().strip().split(","))
                        csv = dict(zip(header, row))

                        for bug_id in args.bug_ids:
                            if not bug_id in not_found:
                                continue
                            if f"{bug_id}_R" in csv:
                                times_R = csv[f"{bug_id}_R"]
                                times_T = csv[f"{bug_id}_T"]
                                if times_T > 0:
                                    print(f"{os.path.relpath(monitor)}: bug_id={bug_id}, {bug_id}_R={times_R}, {bug_id}_T={times_T}")
                                    not_found.remove(bug_id)
